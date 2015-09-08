/**
 * Initialization code goes here. This is not to be a dumping ground for
 * miscellaneous functions, and especially not a place to stick new global
 * variables.
 */
// Translations for i18n L10n
import * as I18nUtils from './utils/I18nUtils.js';

// Page Views
var PageViews = {
  PageView: require('./components/Page.jsx'),
  CityPageView: require('./components/pages/City.jsx'),
  HomePageView: require('./components/pages/Home.jsx'),
  ProfilePageView: require('./components/pages/Profile.jsx'),
  WalkPageView: require('./components/pages/Walk.jsx')
};
var ReactViews = {
  CreateWalkView: require('./components/CreateWalk.jsx')
};
// load modals
var Login = require('./components/Login.jsx')

// Shims
// Used for Intl.DateTimeFormat
if (!window.Intl) {
  window.Intl = require('intl/Intl.en');
}

document.addEventListener('DOMContentLoaded', function() {
  var pageViewName =
    document.body.getAttribute('data-pageViewName') ||
    'PageView';
  var ReactView = ReactViews[pageViewName];

  try {
    // Render modals we need on each page
    var loginEl = <Login socialLogin={(JanesWalk.stacks || {"Social Logins": ""})['Social Logins']} />;

    // FIXME: once site's all-react, move this out of the JanesWalk object. Don't follow this approach
    // or we'll end up with massive spaghetti.
    JanesWalk.react = {
      login: loginEl
    };
    React.render(
      loginEl,
      document.getElementById('modals')
    );

    // Load our translations upfront
    I18nUtils.getTranslations(JanesWalk.locale);

    // Hybrid-routing. First check if there's a React view (which will render
    // nearly all the DOM), or a POJO view (which manipulates PHP-built HTML)
    if (ReactView) {
      switch (pageViewName) {
        case 'CreateWalkView':
          React.render(
            <ReactView
              data={JanesWalk.walk.data}
              city={JanesWalk.city}
              user={JanesWalk.user}
              url={JanesWalk.walk.url}
              valt={JanesWalk.form.valt}
            />,
            document.getElementById('createwalk')
          );
          break;
      }
    } else {
      // FIXME: I'm not in-love with such a heavy jQuery reliance
      new PageViews[pageViewName]($(document.body));
    }
  } catch(e) {
    console.error('Error instantiating page view ' + pageViewName + ': ' + e.stack);
  }

  // Init keyboard shortcuts
  var toolbar = document.getElementById('ccm-toolbar');
  if (toolbar) {
    window.addEventListener('keyup', function(ev) {
      /* Don't capture inputs going into a form */
      if(ev.target.tagName !== "INPUT") {
        ev.preventDefault();
        switch(
          String(
            ev.key ||
            (ev.keyCode && String.fromCharCode(ev.keyCode)) ||
            ev.char)
            .toUpperCase()
        ){
          case "M":
            if (toolbar.style.display === 'block' || !toolbar.style.display) {
              toolbar.style.display = 'none';
            } else {
              toolbar.style.display = 'block';
            }
            break;
          default:
            break;
        }
      }
    });
  }
});