<template>
  <div>
    <v-dialog v-model="dialog" persistent max-width="290">
      <v-card>
        <v-card-title class="headline">Excluir documento?</v-card-title>
        <v-card-text>Tem certeza que queres excluir este documento?</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="red darken-1" flat @click="dialog = false">Não</v-btn>
          <v-btn color="green darken-1" flat @click="deleteItem">Sim</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-toolbar flat color="white">
      <v-toolbar-title>Documentos</v-toolbar-title>
      <v-spacer></v-spacer>

      <v-btn color="primary" dark class="mb-2" @click="novo">Novo documento</v-btn>
    </v-toolbar>
    <v-data-table :headers="headers" :items="items" class="elevation-1">
      <template slot="items" slot-scope="props">
        <td>{{ props.item.nome }}</td>
        <td>{{ props.item.setor }}</td>
        <td>{{ props.item.tipo }}</td>
        <td>{{ props.item.responsavel }}</td>
        <td>{{ props.item.dataCadastrado }}</td>
        <td>{{ props.item.dataVencimento }}</td>
        <td v-if="props.item.arquivo != null && props.item.arquivo != ''">
          <a
            :download="props.item.nome_arquivo"
            :href=" 'data:application/octet-stream;base64,' + props.item.arquivo"
            :title="'Download do arquivo - ' + props.item.nome_arquivo"
          >
            <v-icon>archive</v-icon>
          </a>
        </td>
        <td v-else>-</td>
        <td>
          <v-icon small class="mr-2" @click="editItem(props.item)">edit</v-icon>
          <v-icon small @click="modalItem(props.item)">delete</v-icon>
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
      headers: [
        { text: "Nome", value: "nome" },
        { text: "Setor", value: "setor" },
        { text: "Tipo", value: "tipo" },
        { text: "Responsável", value: "responsavel" },
        { text: "Cadastrado", value: "dataCadastrado" },
        { text: "Vencimento", value: "dataVencimento" },
        { text: "Download" },
        { text: "Ações" }
      ]
    };
  },
  methods: {
    downloadFile: function(item) {
      console.log(item);
      download(item.arquivo, "git.txt", "text/plain");
    },
    novo: function() {
      this.$router.push({ name: "CadastrarDocumento" });
    },
    editItem: function(item) {
      let url = "CadastrarDocumento/" + item.id;
      this.$router.push(url);
    },
    modalItem: function(item) {
      this.item = item;
      this.dialog = true;
    },
    deleteItem: function() {
      axios
        .delete("documentos/" + this.item.id)
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
        .get("documentos")
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