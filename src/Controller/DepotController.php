<?php

namespace App\Controller;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\Funds;
use App\Entity\Rates;
use App\Entity\Depots;
use App\Entity\Persons;
use App\Form\FundsType;
use App\Entity\Retraits;
use App\Entity\Corporations;
use App\Repository\DepotsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DepotController extends AbstractController
{

    private $depots;
    private $em;
    private $request;

    public function __construct(DepotsRepository $dr, EntityManagerInterface $em)
    {
        $this->depots = $dr;
        $this->em = $em;
        $this->request = Request::createFromGlobals();
    }

    /**
     * @Route("/depot/{id}/{id_morale}", name="depot")
     */
    public function index(Persons $persons, $id_morale): Response
    {
        return $this->render(
            'services/depot/index.html.twig',
            [
                'proprietaire' => $this->proprietaire($persons, $id_morale),
                'depots' => $this->depots->findBy(['persons' => $persons, 'corporations' => $this->proprietaire($persons, $id_morale)['corporations']], ['id' => 'desc'])
            ]
        );
    }
    /**
     * @Route("{id}/{id_morale}/depot/new", name="depot_new")
     */
    public function new(Persons $persons, $id_morale): Response
    {
        if ($id_morale == 0)
            $depots = $this->depots->findBy(['persons' => $persons], ['id' => 'desc']);
        else
            $depots =  $this->depots->findBy(['corporations' => $this->getDoctrine()->getRepository(Corporations::class)->findOneBy(['id' => $id_morale])], ['id' => 'desc']);
        if (!empty($depots)) {
            $date_depots = $depots[0]->getCreatedAt()->format('Y-m-d');
            if ($date_depots === date('Y-m-d')) {
                $this->addFlash('info', "Un client ne peut déposer qu'une seule fois de même date");
                return $this->redirectToRoute('depot', ['id' => $persons->getId(), 'id_morale' => $id_morale]);
            }
        }
        $fund = new Funds();
        $form = $this->createForm(FundsType::class, $fund);
        $form->handleRequest($this->request);
        if ($form->isSubmitted() && $form->isValid()) {
            $fund->setRate($this->getDoctrine()->getRepository(Rates::class)->findOneBy(['month' => getdate()['month'], 'year' => getdate()['year']]));
            $depot = new Depots();
            $depot->setCreatedAt(new \DateTime());
            $depot->setEndDate(new \DateTime(date('Y-m-d H:m:s', time() + $fund->getDuration() * 365 * 24 * 60 * 60 + 24 * 60 * 60)));
            $depot->setFund($fund);
            $depot->setPersons($persons);
            if ($id_morale != 0) {
                $corporations = $this->getDoctrine()->getRepository(Corporations::class)->find($id_morale);
                $depot->setCorporations($corporations);
            }
            $this->em->persist($fund);
            $this->em->persist($depot);
            $this->em->flush();
            $this->addFlash('success', 'Un depot a bien été enregistré avec succès');
            return $this->redirectToRoute('depot', ['id' => $persons->getId(), 'id_morale' => $id_morale]);
        }
        return $this->render(
            'services/depot/new.html.twig',
            ['form' => $form->createView(), 'proprietaire' => $this->proprietaire($persons, $id_morale)]
        );
    }
    /**
     * @Route("/{id}/remove", name="remove")
     */
    public function remove(Depots $depots)
    {
        $time = mktime(null, null, null, (int) $depots->getEndDate()->format('m'), (int)$depots->getEndDate()->format('d'), (int)$depots->getEndDate()->format('Y'));
        if (time() < $time) {
            $date = date('d/m/Y', $time);
            $this->addFlash('danger', 'Cette caisse ne peut pas encore être retirer parcequ\'on a pas atteint la fin de delai');
            return $this->redirectToRoute('depot', ['id' => $depots->getPersons()->getId(), 'id_morale' => ($depots->getCorporations()) ? $depots->getCorporations()->getId() : 0]);
        }
        if (!empty($_POST['person_id'])) {
            $retrait = new Retraits();
            $retrait->setCreatedAt(new \DateTime());
            $retrait->setFund($depots->getFund());
            $persons = $this->getDoctrine()->getRepository(Persons::class)->findOneBy(['identity' => $_POST['person_id']]);
            if (!$persons) {
                $this->addFlash('danger', 'Cette personne doit s\'inscrire parce qu\'il n\'est pas connu dans notre service');
            } else {
                $retrait->setPerson($persons);
                $depots->setIsRetired(true);
                $this->em->persist($retrait);
                $this->em->flush();
                $this->addFlash('success', 'Une caisse a bien été retirée avec succès');
                return $this->redirectToRoute(
                    'depot',
                    [
                        'id' => $depots->getPersons()->getId(),
                        'id_morale' => ($depots->getCorporations() != null) ? $depots->getCorporations()->getId() : 0
                    ]
                );
            }
        }
        return $this->render('services/retrait/new.html.twig', compact('depots'));
    }
    /**
     * @Route("/retrait/{fund}", name="show_retrait")
     */
    public function show_retrait(Retraits $retraits)
    {
        return $this->render('services/retrait/show.html.twig', compact('retraits'));
    }
    public function proprietaire($persons, $id_morale)
    {
        $proprietaire = [];
        $proprietaire['name'] = $persons->getName();
        $proprietaire['id'] = $persons->getId();
        $proprietaire['corporation'] = 0;
        $proprietaire['corporations'] = null;
        if ($id_morale != 0) {
            $corporations = $this->getDoctrine()->getRepository(Corporations::class)->find($id_morale);
            $proprietaire['corporations'] = $corporations;
            $proprietaire['name'] = $corporations->getSocialReason();
            $proprietaire['corporation'] = $corporations->getId();
        }
        return $proprietaire;
    }
    /**
     * @Route("/contrat/{id}", name="contrat")
     */
    public function printContrat(Depots $depot)
    {
        $html = $this->renderView('layout/contrat.html.twig', [
            'date' => new \DateTime(),
            'person' => $depot->getPersons(),
            'depot' => $depot,
            'morale' => $depot->getCorporations() ? $depot->getCorporations()->getSocialReason() : null
        ]);

        $dompdf = new Dompdf();

        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();
        // dd($dompdf);

        // Output the generated PDF to Browser
        $dompdf->stream("_CDC_PackDigital.pdf", [
            "Attachment" => false
        ]);
        return new Response('', 200, [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
?>
