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

Vue.use(Router)

export default new Router({
  mode: 'history',
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
      component: CadastrarAdministrador
    },
    {
      path: '/Ged',
      name: 'Menu',
      component: Menu,
      children: [
        {
          path: "/Dashboard",
          name: 'Dashboard',
          component: Dashboard
        },
        {
          path: '/DocumentosVencidos',
          name: 'DocumentosVencidos',
          component: DocumentosVencimento
        },
        {
          path: '/BuscaDocumentos',
          name: 'BuscaDocumentos',
          component: BuscarDocumentos
        },
        {
          path: '/ListaDocumentos',
          name: 'ListaDocumentos',
          component: ListaDocumento
        },
        {
          path: '/CadastrarDocumento',
          name: 'CadastrarDocumento',
          component: CadastrarDocumento
        },
        {
          path: '/CadastrarDocumento/:id',
          props: true,
          name: 'CadastrarDocumento2',
          component: CadastrarDocumento
        },

        {
          path: '/ListaUsuarios',
          name: 'ListaUsuarios',
          component: ListaUsuario
        },
        {
          path: '/CadastrarUsuario',
          name: 'CadastrarUsuario',
          component: CadastrarUsuario
        },
        {
          path: '/CadastrarUsuario/:id',
          props: true,
          name: 'CadastrarUsuario2',
          component: CadastrarUsuario
        },

      ]
    },
  ]
})
