/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */

import './styles/app.scss';
import './styles/own_style.css';

// You can specify which plugins you need
import { Tooltip, Toast, Popover} from './bootstrap';

// start the Stimulus application
import './bootstrap.js';
// import './custom';
