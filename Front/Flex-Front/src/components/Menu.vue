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
      <v-list>
        <v-list-group no-action prepend-icon="create">
          <v-list-tile slot="activator">
            <v-list-tile-title>Cadastros</v-list-tile-title>
          </v-list-tile>
          <v-list-tile sub-group v-for="item in listaMenuAdministrador" :key="item.nome">
            <v-list-tile-title>
              <router-link :to="{name: item.path}">{{item.title}}</router-link>
            </v-list-tile-title>
          </v-list-tile>
        </v-list-group>
        <v-list-tile v-for="item in listaMenu" :key="item.nome">
          <v-list-tile-action>
            <v-icon>{{item.icon}}</v-icon>
          </v-list-tile-action>
          <v-list-tile-title>
            <router-link :to="{name: item.path}">{{item.title}}</router-link>
          </v-list-tile-title>
        </v-list-tile>
      </v-list>
    </v-navigation-drawer>
    <v-toolbar dense app :clipped-left="clipped">
      <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>

      <v-toolbar-title>Flex Industries</v-toolbar-title>

      <v-spacer></v-spacer>
      <v-menu offset-y>
        <v-toolbar-title slot="activator">Pedro</v-toolbar-title>
        <v-list>
          <v-list-tile>
            <v-list-tile-title style="cursor:pointer" @click="sair">Sair</v-list-tile-title>
          </v-list-tile>
        </v-list>
      </v-menu>
    </v-toolbar>
    <v-content style="background: whitesmoke">
      <router-view style="background: white;margin: 18px"/>
    </v-content>
    <v-footer :fixed="fixed" class="footer" app>
      <span>Copyright {{new Date().getFullYear()}} © Flex Industries. Todos os direitos reservados.</span>
    </v-footer>
  </v-app>
</template>


<script>
export default {
  data() {
    return {
      drawer: false,
      clipped: false,
      drawer: false,
      fixed: false,
      miniVariant: false,
      listaMenu: [
        {
          icon: "insert_drive_file",
          title: "Documentos",
          path: "DocumentosVencidos"
        }
      ],
      listaMenuAdministrador: [
        {
          title: "Setores",
          path: ""
        },
        {
          title: "Tipo de documentos",
          path: ""
        },
        {
          title: "Documentos",
          path: ""
        },
        {
          title: "Usuarios",
          path: ""
        }
      ]
    };
  },
  methods: {
    sair: function() {
      alert("saindo");
    }
  }
};
</script>

<style>
a {
  color: black !important;
  text-decoration: none;
}
</style>
