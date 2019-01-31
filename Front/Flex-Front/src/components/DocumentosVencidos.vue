<template>
  <div>
    <v-form>
      <v-container>
        <h3>Documentos vencidos</h3>
        <br>
        <h4>Filtros bases:</h4>
        <v-layout>
          <v-flex xs12 md2>
            <v-text-field v-model="data" label="Data base" type="date" required></v-text-field>
          </v-flex>
          <v-flex xs12 md2>
            <v-select
              item-text="text"
              item-value="value"
              v-model="filtro.diferenca"
              :items="itemsDiferenca"
              label="Periodo de diferença"
            ></v-select>
          </v-flex>
          <v-flex xs12 md2>
            <v-btn color="success" @click="carregar">Carregar</v-btn>
          </v-flex>
        </v-layout>
        <h4>Filtros especiais: (opcionais)</h4>
        <v-layout>
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
      headers: [
        { text: "Documento", value: "name" },
        { text: "Tipo", value: "tipo" },
        { text: "Setor", value: "setor" },
        { text: "Responsavel", value: "responsavel" },
        { text: "Cadastrado", value: "cadastrado" },
        { text: "Vencimento", value: "vencimento" }
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
      data: "",
      filtro: {
        data: "",
        diferenca: "10",
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
      let date = this.data.split("-");
      this.filtro.data = date[0] + "" + date[1] + "" + date[2];
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
        .post("documentosvencidos", this.filtro)
        .then(response => {
          this.items = response.data;
        })
        .catch(e => {
          console.log(e);
        });
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
      .get("setores")
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