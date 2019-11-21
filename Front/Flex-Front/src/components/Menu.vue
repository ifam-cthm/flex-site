<template>
  <v-app>
    <v-navigation-drawer
      persistent
      :mini-variant="miniVariant"
      :clipped="clipped"
      v-model="drawer"
      enable-resize-watcher
      fixed
      app
    >
      <v-img :aspect-ratio="16/9">
        <v-layout pa-2 column fill-height class="lightbox white--text">
          <v-spacer></v-spacer>
          <v-flex shrink style="color: black;">
            <img src="../assets/logo.jpg" alt="Perfil" style="height:50%">
            <div class="subheading">{{usuario.nome}}</div>
            <div class="body-1">{{usuario.email}}</div>
          </v-flex>
        </v-layout>
      </v-img>
      <v-list>
        <v-list-group v-if="usuario.administrador == '1'" no-action prepend-icon="create">
          <v-list-tile slot="activator">
            <v-list-tile-title>Cadastros</v-list-tile-title>
          </v-list-tile>
          <v-list-tile sub-group v-for="item in listaMenuAdministrador" :key="item.nome">
            <v-list-tile-title>
              <router-link :to="{name: item.path}">{{item.title}}</router-link>
            </v-list-tile-title>
          </v-list-tile>
        </v-list-group>
        <v-list-tile v-if="usuario.administrador == '0'">
          <v-list-tile-action>
            <v-icon>insert_drive_file</v-icon>
          </v-list-tile-action>
          <v-list-tile-title>
            <router-link :to="{name: 'ListaDocumentosNormal'}">Cadastro de documentos</router-link>
          </v-list-tile-title>
        </v-list-tile>
        <v-list-tile>
          <v-list-tile-action>
            <v-icon>dashboard</v-icon>
          </v-list-tile-action>
          <v-list-tile-title>
            <router-link :to="{name: 'Dashboard'}">Dashboard</router-link>
          </v-list-tile-title>
        </v-list-tile>
        <v-list-group no-action prepend-icon="insert_drive_file">
          <v-list-tile slot="activator">
            <v-list-tile-title>Documentos</v-list-tile-title>
          </v-list-tile>
          <v-list-tile sub-group v-for="item in listaMenuDocumentos" :key="item.nome">
            <v-list-tile-title>
              <router-link :to="{name: item.path}">{{item.title}}</router-link>
            </v-list-tile-title>
          </v-list-tile>
        </v-list-group>
        <v-list-group no-action prepend-icon="insert_drive_file">
          <v-list-tile slot="activator">
            <v-list-tile-title>Notificações</v-list-tile-title>
          </v-list-tile>
          <v-list-tile sub-group v-for="item in listaMenuNotificacoes" :key="item.nome">
            <v-list-tile-title>
              <router-link :to="{name: item.path}">{{item.title}}</router-link>
            </v-list-tile-title>
          </v-list-tile>
        </v-list-group>
        <!-- <v-list-tile v-for="item in listaMenu" :key="item.nome">
          <v-list-tile-action>
            <v-icon>{{item.icon}}</v-icon>
          </v-list-tile-action>
          <v-list-tile-title>
            <router-link :to="{name: item.path}">{{item.title}}</router-link>
          </v-list-tile-title>
        </v-list-tile>-->
      </v-list>
    </v-navigation-drawer>
    <v-toolbar dense app :clipped-left="clipped">
      <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>

      <v-toolbar-title>Flex Industries</v-toolbar-title>

      <v-spacer></v-spacer>
      <v-menu offset-y>
        <v-toolbar-title slot="activator">{{usuario.login}}</v-toolbar-title>
        <v-list>
          <v-list-tile style="cursor:pointer" @click="sair">
            <v-list-tile-title>Sair</v-list-tile-title>
          </v-list-tile>
        </v-list>
      </v-menu>
    </v-toolbar>
    <v-content style="background: whitesmoke">
      <router-view style="background: white;margin: 18px"/>
    </v-content>
    <v-footer :fixed="fixed" class="footer" app>
      <span>Copyright {{new Date().getFullYear()}} Â© Flex Industries. Todos os direitos reservados.</span>
    </v-footer>
  </v-app>
</template>


<script>
export default {
  data() {
    return {
      usuario: {},
      drawer: false,
      clipped: false,
      drawer: false,
      fixed: false,
      miniVariant: false,
      listaMenuDocumentos: [
        {
          icon: "insert_drive_file",
          title: "Documentos",
          path: "DocumentosVencidos"
        },
        {
          icon: "insert_drive_file",
          title: "Buscar documentos",
          path: "BuscaDocumentos"
        }
      ],
      listaMenuAdministrador: [
        {
          title: "Setores",
          path: "ListarSetores"
        },
        {
          title: "Tipo de documentos",
          path: "ListarTipos"
        },
        {
          title: "Documentos",
          path: "ListaDocumentos"
        },
        {
          title: "Usuarios",
          path: "ListaUsuarios"
        },
        {
          title: "Ativos",
          path: ""
        }
      ],
      listaMenuNotificacoes: [
        {
          title: "Configurar Notificações",
          path: "ConfigurarNotificacoes"
        },
        {
          title: "Notificações",
          path: ""
        }
      ]
    };
  },
  methods: {
    sair: function() {
      localStorage.setItem("flex-site_cthm", null);
      this.$router.push({ name: "Login" });
    }
  },
  created: function() {
    let usuario = JSON.parse(localStorage.getItem("flex-site_cthm"));
    this.usuario = usuario;
    console.log(this.usuario);
  }
};
</script>

<style>
a {
  color: black !important;
  text-decoration: none;
}
</style>
