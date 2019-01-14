import Vue from 'vue'
import Router from 'vue-router'
import Login from '@/components/Login'
import CadastrarAdministrador from '@/components/CadastrarAdministrador.vue'
import CadastrarDocumento from '@/components/CadastrarDocumento.vue'
import Menu from '@/components/Menu.vue'
import DocumentosVencimento from '@/components/DocumentosVencidos.vue'
Vue.use(Router)

export default new Router({
  mode: 'history',
  routes: [{
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
      children: [{
          path: '/DocumentosVencidos',
          name: 'DocumentosVencidos',
          component: DocumentosVencimento
        },
        {
          path: '/CadastrarDocumento',
          name: 'CadastrarDocumento',
          component: CadastrarDocumento
        }
      ]
    },
  ]
})
