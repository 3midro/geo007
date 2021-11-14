
import HomePage from '../pages/home.f7.html';
import AboutPage from '../pages/about.f7.html';
import FormPage from '../pages/form.f7.html';

import LeftPage1 from '../pages/left-page-1.f7.html';
import LeftPage2 from '../pages/left-page-2.f7.html';
import DynamicRoutePage from '../pages/dynamic-route.f7.html';
import RequestAndLoad from '../pages/request-and-load.f7.html';
import NotFoundPage from '../pages/404.f7.html';
//lista negra
import BlackList from '../pages/blackList.f7.html';
import addBlackList from '../pages/addblackList.f7.html';
//personas
import personas from '../pages/personasList.f7.html';
import addpersonasList from '../pages/addpersonasList.f7.html';
//contratos
import contratos from '../pages/contratosList.f7.html';
import addcontrato from '../pages/addcontrato.f7.html';
//pagos
import pagos from '../pages/pagosList.f7.html';
import addpago from '../pages/addpago.f7.html';
//cargos
import cargos from '../pages/cargosList.f7.html';
import addcargo from '../pages/addcargo.f7.html';
//firma
import signature from '../pages/signature.f7.html';
//accounting
import accountingDashboard from '../pages/accountingDashboard.f7.html';
import addAccountingMovement from '../pages/addAccountingMovement.f7.html';
import accountingDetail from '../pages/accountingDetail.f7.html';

var routes = [
  {
    path: '/',
    component: HomePage,
  },
  {
    path: '/about/',
    component: AboutPage,
  },
  {
    path: '/accountingDashboard/',
    component: accountingDashboard,
    name: 'accountingDashboard',
    master: true,
    detailRoutes:[
      {
        path: '/accountingDetail/:cuenta/:alias',
        component: accountingDetail,
        name: 'accountingDetail',
        
      },
      {
        path: '/addAccountingMovement/',
        component: addAccountingMovement,
        on:{
          pageInit: function (e, page) {
            //sessionStorage.setItem('refresh', true);
          }
        }
      },
    ]
  },
 
  
  {
    path: '/form/',
    component: FormPage,
  },
  {
    path:'/blacklist',
    component: BlackList,
  },
  {
    path:'/addblacklist',
    component: addBlackList,
  },
  {
    path:'/pagos',
    component: pagos,
  },
  {
    path:'/addpago',
    component: addpago,
  },
  {
    path:'/cargos',
    component: cargos,
  },
  {
    path:'/addcargo',
    component: addcargo,
  },
  {
    path:'/personas',
    component: personas,
  },
  {
    path:'/addpersonasList',
    component: addpersonasList,
    on:{
      pageInit: function (e, page) {
        // do something when page initialized
        console.log("ya inicio la pagina de addPersonasList");
       
  
      },
    }
  },
  {
    path:'/contratosList',
    component: contratos,
  },
  {
    path:'/addcontrato',
    component: addcontrato,
  },
  {
    path:'/signature',
    component: signature,
  },
  {
    path: '/left-page-1/',
    component: LeftPage1,
  },
  {
    path: '/left-page-2/',
    component: LeftPage2,
  },
  {
    path: '/dynamic-route/blog/:blogId/post/:postId/',
    component: DynamicRoutePage,
  },
  {
    path: '/request-and-load/user/:userId/',
    async: function ({ router, to, resolve }) {
      // App instance
      var app = router.app;

      // Show Preloader
      app.preloader.show();

      // User ID from request
      var userId = to.params.userId;

      // Simulate Ajax Request
      setTimeout(function () {
        // We got user data from request
        var user = {
          firstName: 'Vladimir',
          lastName: 'Kharlampidi',
          about: 'Hello, i am creator of Framework7! Hope you like it!',
          links: [
            {
              title: 'Framework7 Website',
              url: 'http://framework7.io',
            },
            {
              title: 'Framework7 Forum',
              url: 'http://forum.framework7.io',
            },
          ]
        };
        // Hide Preloader
        app.preloader.hide();

        // Resolve route to load page
        resolve(
          {
            component: RequestAndLoad,
          },
          {
            props: {
              user: user,
            }
          }
        );
      }, 1000);
    },
  },
  {
    path: '(.*)',
    component: NotFoundPage,
  },
];

export default routes;