<template>
  <div>
    <v-snackbar
      v-model="snackbar"
      :bottom="y === 'bottom'"
      :left="x === 'left'"
      :multi-line="mode === 'multi-line'"
      :right="x === 'right'"
      timeout="2000"
      :top="y === 'top'"
      :vertical="mode === 'vertical'"
      color="#689F39"
    >Pesquisa foi concluída
      <v-btn color="white" flat @click="snackbar = false">Close</v-btn>
    </v-snackbar>
    <div class="text-xs-center">
      <v-dialog v-model="dialog" hide-overlay persistent width="300">
        <v-card color="sucess" style="background-color: #689F39;">
          <v-card-text style="color: white;">Carregando dados
            <v-progress-linear indeterminate color="white" class="mb-0"></v-progress-linear>
          </v-card-text>
        </v-card>
      </v-dialog>
    </div>
    <v-form>
      <v-container>
        <h3>Documentos</h3>
        <br>
        <h4>Filtros:</h4>
        <v-layout>
          <v-flex xs12 md4>
            <v-text-field label="Nome do documento" placeholder="Nome" v-model="filtro.nome"></v-text-field>
          </v-flex>
          <v-flex xs12 md4>
            <v-select
              item-text="nome"
              item-value="nome"
              v-model="filtro.s1"
              :items="itemsSetor"
              label="Setor"
            ></v-select>
          </v-flex>

          <v-flex xs12 md4>
            <v-select
              item-text="nome"
              item-value="nome"
              v-model="filtro.t1"
              :items="itemsTipos"
              label="Tipo de documento"
            ></v-select>
          </v-flex>

          <v-flex xs12 md4>
            <v-autocomplete
              v-model="filtro.r1"
              item-text="nome"
              item-value="nome"
              :items="itemsResponsaveis"
              label="Responsáveis"
              persistent-hint
              prepend-icon="mdi-city"
            ></v-autocomplete>
          </v-flex>
          <v-flex xs12 md2>
            <v-btn color="success" @click="carregar">Carregar</v-btn>
          </v-flex>
          <v-flex xs12 md2>
            <v-btn color="warning" @click="limpar">Limpar</v-btn>
          </v-flex>
        </v-layout>
      </v-container>
    </v-form>
    <v-data-table style="margin: 20px; " :headers="headers" :items="items" class="elevation-1">
      <template slot="items" slot-scope="props">
        <td>{{ props.item.nome }}</td>
        <td>{{ props.item.tipo }}</td>
        <td>{{ props.item.setor }}</td>
        <td>{{ props.item.responsavel }}</td>
        <td>{{ props.item.cadastrado }}</td>
        <td>{{ props.item.vencimento }}</td>
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
      dialog: false,
      snackbar2: false,
      headers: [
        { text: "Documento", value: "name" },
        { text: "Tipo", value: "tipo" },
        { text: "Setor", value: "setor" },
        { text: "Responsavel", value: "responsavel" },
        { text: "Cadastrado", value: "cadastrado" },
        { text: "Vencimento", value: "vencimento" },
        { text: "Download" }
      ],
      itemsDiferenca: [
        { value: "1", text: "1 dia" },
        { value: "7", text: "1 Semana" },
        { value: "10", text: "10 dias" },
        { value: "30", text: "1 mês" },
        { value: "365", text: "1 ano" }
      ],
      items: [],
      itemsSetor: [],
      itemsTipos: [],
      itemsResponsaveis: [],
      filtro: {
        nome: "",
        s1: "",
        s2: "",
        t1: "",
        t2: "",
        r1: "",
        r2: ""
      }
    };
  },
  methods: {
    carregar: function() {
      this.items = [];
      this.dialog = true;
      if (this.filtro.s1 != "" && this.filtro.s1 != "   ") {
        this.filtro.s2 = this.filtro.s1;
      } else {
        this.filtro.s1 = "   ";
        this.filtro.s2 = "ZZZZ";
      }
      if (this.filtro.t1 != "" && this.filtro.t1 != "   ") {
        this.filtro.t2 = this.filtro.t1;
      } else {
        this.filtro.t1 = "   ";
        this.filtro.t2 = "ZZZZ";
      }
      if (this.filtro.r1 != "" && this.filtro.r1 != "   ") {
        this.filtro.r2 = this.filtro.r1;
      } else {
        this.filtro.r1 = "   ";
        this.filtro.r2 = "ZZZZ";
      }
      axios
        .post("documentosencontrados", this.filtro)
        .then(response => {
          this.dialog = false;
          this.items = response.data;
          this.snackbar = true;
        })
        .catch(e => {
          console.log(e);
        });
    },
    limpar: function() {
      this.filtro = {
        nome: "",
        s1: "",
        s2: "",
        t1: "",
        t2: "",
        r1: "",
        r2: ""
      };
    }
  },
  created: function() {
    let date = new Date();
    let dia1;
    let mes1;
    let ano1;
    if (date.getDate() < 10) {
      dia1 = "0" + date.getDate();
    } else {
      dia1 = date.getDate();
    }

    if (date.getMonth() + 1 < 10) {
      mes1 = "0" + (date.getMonth() + 1);
    } else {
      mes1 = date.getMonth() + 1;
    }

    ano1 = date.getFullYear();
    this.data = ano1 + "-" + mes1 + "-" + dia1;

    axios
      .get("setor")
      .then(response => {
        this.itemsSetor = response.data;
      })
      .catch(e => {});
    axios
      .get("tipos")
      .then(response => {
        this.itemsTipos = response.data;
      })
      .catch(e => {});
    axios
      .get("responsaveis")
      .then(response => {
        this.itemsResponsaveis = response.data;
      })
      .catch(e => {});
  }
};
</script>

<style>
thead {
  background-color: darkgray !important;
}
</style>