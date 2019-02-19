import Vue from 'vue'
import Router from 'vue-router'
import Login from '@/components/Login'
import CadastrarAdministrador from '@/components/CadastrarAdministrador.vue'
/////////////////////////
import CadastrarDocumento from '@/components/CadastrarDocumento.vue'
import ListaDocumento from '@/components/ListaDocumentos.vue'
///////////////////////////
/////////////////////////
import CadastrarUsuario from '@/components/CadastrarUsuario.vue'
import ListaUsuario from '@/components/ListaUsuario.vue'
///////////////////////////
import Menu from '@/components/Menu.vue'
import DocumentosVencimento from '@/components/DocumentosVencidos.vue'
////////////////////////////////////////////////////
import BuscarDocumentos from '@/components/BuscarDocumentos.vue'
/////////////////////////////////////////////////////////////
import Dashboard from '@/components/Dashboard.vue'
//////////////////////////////////////////////////////////////
import CadastrarSetores from '@/components/CadastrarSetores.vue'
import ListarSetores from '@/components/ListarSetores.vue'
/////////////////////////////////////////////////////////////
import CadastrarTipos from '@/components/CadastrarTipos.vue'
import ListarTipos from '@/components/ListarTipos.vue'


Vue.use(Router)

function isLogado() {
  var usuario = JSON.parse(localStorage.getItem("flex-site_cthm"));
  if (usuario != null && usuario.nome != "" && usuario.login != "") {
    return true;
  } else {
    localStorage.setItem("flex-site_cthm", null);
    return false;
  }
}

function verificarLogin(to, next) {
  if (!isLogado()) {
    next('/')
  } else {
    next()
  }
}

export default new Router({
  mode: 'history',
  relative: true,
  base: '/flex-site/flex',
  routes: [{
    path: "*",
    redirect: "/Dashboard"
  },
  {
    path: '/',
    name: 'Login',
    component: Login
  },
  {
    path: '/CadastrarAdministrador',
    name: 'CadastrarAdministrador',
    component: CadastrarAdministrador,
    beforeEnter(to, from, next) {
      verificarLogin(to, next)
    }
  },
  {
    path: '/Ged',
    name: 'Menu',
    component: Menu,
    children: [{
      path: "/",
      name: 'Dashboard',
      component: Dashboard,
      beforeEnter(to, from, next) {
        verificarLogin(to, next)
      }
    },
    {
      path: '/DocumentosVencidos',
      name: 'DocumentosVencidos',
      component: DocumentosVencimento,
      beforeEnter(to, from, next) {
        verificarLogin(to, next)
      }
    },
    {
      path: '/BuscaDocumentos',
      name: 'BuscaDocumentos',
      component: BuscarDocumentos,
      beforeEnter(to, from, next) {
        verificarLogin(to, next)
      }
    },
    {
      path: '/ListaDocumentos',
      name: 'ListaDocumentos',
      component: ListaDocumento,
      beforeEnter(to, from, next) {
        verificarLogin(to, next)
      }
    },
    {
      path: '/CadastrarDocumento',
      name: 'CadastrarDocumento',
      component: CadastrarDocumento,
      beforeEnter(to, from, next) {
        verificarLogin(to, next)
      }
    },
    {
      path: '/CadastrarDocumento/:id',
      props: true,
      name: 'CadastrarDocumento2',
      component: CadastrarDocumento,
      beforeEnter(to, from, next) {
        verificarLogin(to, next)
      }
    },
    {
      path: '/ListaUsuarios',
      name: 'ListaUsuarios',
      component: ListaUsuario,
      beforeEnter(to, from, next) {
        verificarLogin(to, next)
      }
    },
    {
      path: '/CadastrarUsuario',
      name: 'CadastrarUsuario',
      component: CadastrarUsuario,
      beforeEnter(to, from, next) {
        verificarLogin(to, next)
      }
    },
    {
      path: '/CadastrarUsuario/:id',
      props: true,
      name: 'CadastrarUsuario2',
      component: CadastrarUsuario,
      beforeEnter(to, from, next) {
        verificarLogin(to, next)
      }
    },
    {
      path: '/ListaSetores',
      name: 'ListarSetores',
      component: ListarSetores,
      beforeEnter(to, from, next) {
        verificarLogin(to, next)
      }
    },
    {
      path: '/CadastrarSetores',
      name: 'CadastrarSetores',
      component: CadastrarSetores,
      beforeEnter(to, from, next) {
        verificarLogin(to, next)
      }
    },
    {
      path: '/CadastrarSetores/:id',
      props: true,
      name: 'CadastrarSetores2',
      component: CadastrarSetores,
      beforeEnter(to, from, next) {
        verificarLogin(to, next)
      }
    },
    {
      path: '/ListaTipos',
      name: 'ListarTipos',
      component: ListarTipos,
      beforeEnter(to, from, next) {
        verificarLogin(to, next)
      }
    },
    {
      path: '/CadastrarTipos',
      name: 'CadastrarTipos',
      component: CadastrarTipos,
      beforeEnter(to, from, next) {
        verificarLogin(to, next)
      }
    },
    {
      path: '/CadastrarTipos/:id',
      props: true,
      name: 'CadastrarTipos2',
      component: CadastrarTipos,
      beforeEnter(to, from, next) {
        verificarLogin(to, next)
      }
    },
    ]
  },
  ]
})
