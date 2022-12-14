/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// start the Stimulus application
import './bootstrap';


import React from 'react';
import { createRoot } from 'react-dom/client';

import Default from './components/Default';

/*
    var datas = JSON.parse(document.getElementById('dashboard').dataset.page);
    var elt = <DefaultDashboard datas={datas} />;
*/

// Default
if(document.getElementById('default') !== null) {
    var root = createRoot(document.getElementById('default'));
    var elt = <Default />;
    root.render(elt);
}