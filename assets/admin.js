//Styles
import './lib/font-awesome.css';
import './lib/bootstrap.min.css';
import './css/base.css';
//Scripts
import './lib/bootstrap.bundle.min.js';
import './lib/jquery.min.js';
import $ from './lib/jquery.min.js';


$('.custom-file-input').on('change', function (params) {
    const input = params.currentTarget;
    $(input).parent().find('.custom-file-label').html(input.files[0].name);
})

