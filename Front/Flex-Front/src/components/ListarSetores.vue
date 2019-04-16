<template>
  <div>
    <v-dialog v-model="dialog" persistent max-width="290">
      <v-card>
        <v-card-title class="headline">Excluir Setor?</v-card-title>
        <v-card-text>Tem certeza que queres excluir este Setor?</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="red darken-1" flat @click="dialog = false">NÃ£o</v-btn>
          <v-btn color="green darken-1" flat @click="deleteItem">Sim</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
        <v-dialog v-model="dialogErro1" width="500">
      <v-card>
        <v-card-title class="headline grey lighten-2" primary-title>Erro</v-card-title>

        <v-card-text>Você não tem acesso a essa página entre em contato com os Administradores para saber mais</v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" flat @click="dialogErro1= !dialogErro1">Ok</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-dialog v-model="dialogRecuperar" persistent max-width="290">
      <v-card>
        <v-card-title class="headline">Recuperar Setor?</v-card-title>
        <v-card-text>Tem certeza que queres recuperar este Setor?</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="red darken-1" flat @click="dialogRecuperar = false">Não</v-btn>
          <v-btn color="green darken-1" flat @click="recuperarItem">Sim</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-toolbar flat color="white">
      <v-toolbar-title>Setores</v-toolbar-title>
      <v-spacer></v-spacer>

      <v-btn color="primary" dark class="mb-2" @click="novo">Novo Setor</v-btn>
    </v-toolbar>
    <v-data-table :headers="headers" :items="items" class="elevation-1">
      <template slot="items" slot-scope="props">
        <td>{{ props.item.nome }}</td>
        <td>
          <v-icon color="green" v-if="props.item.bloqueado == 0">fiber_manual_record</v-icon>
          <v-icon color="red" v-else>fiber_manual_record</v-icon>
        </td>
        <td v-if="props.item.bloqueado == 0">
          <v-icon small class="mr-2" @click="editItem(props.item)">edit</v-icon>
          <v-icon small @click="modalItem(props.item)">delete</v-icon>
        </td>
        <td v-else>
          <v-icon small class="mr-2" @click="modalRecuperar(props.item)">add</v-icon>
        </td>
      </template>
    </v-data-table>
  </div>
</template>

<script>
import axios from "../axios/client.js";
export default {
  name: "",
  data() {
    return {
      items: [],
      item: {},
      usuario:{},
      dialog: false,
      dialogRecuperar: false,
      headers: [
        { text: "Nome", value: "nome" },
        { text: "Bloqueado", value: "bloqueado" },
        { text: "Ações" }
      ]
    };
  },
  methods: {
    novo: function() {
      this.$router.push({ name: "CadastrarSetores" });
    },
    editItem: function(item) {
      let url = "CadastrarSetores/" + item.id;
      this.$router.push(url);
    },
    modalRecuperar: function(item) {
      this.item = item;
      this.dialogRecuperar = true;
    },
    modalItem: function(item) {
      this.item = item;
      this.dialog = true;
    },
    recuperarItem: function() {
      axios
        .get("setorRecuperar/" + this.item.id)
        .then(response => {
          if (response.data) {
            this.carregar();
            this.dialogRecuperar = false;
          } else {
            this.dialogRecuperar = false;
          }
        })
        .catch(e => {
          this.dialogRecuperar = false;
        });
    },
    deleteItem: function() {
      axios
        .delete("setor/" + this.item.id)
        .then(response => {
          if (response.data) {
            this.carregar();
            this.dialog = false;
          } else {
            this.dialog = false;
          }
        })
        .catch(e => {
          this.dialog = false;
        });
    },
    carregar: function() {
      axios
        .get("setor")
        .then(response => {
          this.items = response.data;
        })
        .catch(e => {});
    }
  },
  created: function() {
    let usuario = JSON.parse(localStorage.getItem("flex-site_cthm"));
    this.usuario = usuario
//    if(this.usuario.administrador==true)
      this.carregar();
  //  else
  }
};
</script>

<style>
</style>