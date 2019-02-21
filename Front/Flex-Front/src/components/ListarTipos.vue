<template>
  <div>
    <v-dialog v-model="dialog" persistent max-width="290">
      <v-card>
        <v-card-title class="headline">Excluir tipo?</v-card-title>
        <v-card-text>Tem certeza que queres excluir este tipo?</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="red darken-1" flat @click="dialog = false">NÃ£o</v-btn>
          <v-btn color="green darken-1" flat @click="deleteItem">Sim</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-dialog v-model="dialogRecuperar" persistent max-width="290">
      <v-card>
        <v-card-title class="headline">Recuperar tipo?</v-card-title>
        <v-card-text>Tem certeza que queres recuperar este tipo?</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="red darken-1" flat @click="dialogRecuperar = false">Não</v-btn>
          <v-btn color="green darken-1" flat @click="recuperarItem">Sim</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-toolbar flat color="white">
      <v-toolbar-title>Tipos de Documentos</v-toolbar-title>
      <v-spacer></v-spacer>

      <v-btn color="primary" dark class="mb-2" @click="novo">Novo Tipo</v-btn>
    </v-toolbar>
    <v-data-table :headers="headers" :items="items" class="elevation-1">
      <template slot="items" slot-scope="props">
        <td>{{ props.item.nome }}</td>
        <td>{{props.item.descricao}}</td>
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
      dialog: false,
      dialogRecuperar: false,
      headers: [
        { text: "Nome", value: "nome" },
        { text: "Descrição", value: "descricao" },
        { text: "Disponível", value: "bloqueado" },
        { text: "Ações" }
      ]
    };
  },
  methods: {
    novo: function() {
      this.$router.push({ name: "CadastrarTipos" });
    },
    editItem: function(item) {
      let url = "CadastrarTipos/" + item.id;
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
    deleteItem: function() {
      axios
        .delete("tipos/" + this.item.id)
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
    recuperarItem: function() {
      axios
        .get("tiposRecuperar/" + this.item.id)
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
    carregar: function() {
      axios
        .get("tipos")
        .then(response => {
          this.items = response.data;
        })
        .catch(e => {});
    }
  },
  created: function() {
    this.carregar();
  }
};
</script>

<style>
</style>