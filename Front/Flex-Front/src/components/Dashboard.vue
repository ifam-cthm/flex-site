<template>
  <div>
    <v-layout row wrap>
      <v-flex xs5 style="margin: auto">
        <span>Usu&aacuterios X Documentos</span>
        <apexchart
          type="bar"
          :options="options_graficoDocumentosUsuarios"
          :series="series_graficoDocumentosUsuarios"
        ></apexchart>
      </v-flex>
      <v-flex xs5 style="margin: auto">
        <span>Tipos X Documentos</span>
        <apexchart type="bar" :options="options_graficoDocumentosTipos" :series="series_graficoDocumentosTipos"></apexchart>
      </v-flex>
    </v-layout>
  </div>
</template>

<script>
import VueApexCharts from "vue-apexcharts";
import axios from "../axios/client.js";
export default {
  components: {
    apexchart: VueApexCharts
  },
  name: "Dashboard",
  data: function() {
    return {
      graficoDocumentosUsuarios: {
        usuarios: [],
        quantidades: []
      },
      options_graficoDocumentosUsuarios: {},
      series_graficoDocumentosUsuarios: [],
      ///////////////////////////////////////////////////
      graficoDocumentosTipos: {
        tipos: [],
        quantidades: []
      },
      options_graficoDocumentosTipos: {},
      series_graficoDocumentosTipos: []
    };
  },
  mounted: function() {
    axios
      .get("get_grafico_documentosXusuarios")
      .then(response => {
        this.graficoDocumentosUsuarios = response.data;
        (this.options_graficoDocumentosUsuarios = {
          chart: {
            id: "grafico_documentosXusuarios"
          },
          xaxis: {
            categories: this.graficoDocumentosUsuarios.usuarios
          }
        }),
          (this.series_graficoDocumentosUsuarios = [
            {
              name: "Quantidade de documentos",
              data: this.graficoDocumentosUsuarios.quantidades
            }
          ]);
      })
      .catch(e => {});

    axios
      .get("get_grafico_documentosXtipos")
      .then(response => {
        this.graficoDocumentosTipos = response.data;
        (this.options_graficoDocumentosTipos = {
          chart: {
            id: "grafico_documentosXtipos"
          },
          xaxis: {
            categories: this.graficoDocumentosTipos.tipos
          }
        }),
          (this.series_graficoDocumentosTipos = [
            {
              name: "Quantidade de documentos",
              data: this.graficoDocumentosTipos.quantidades
            }
          ]);
      })
      .catch(e => {});
  }
};
</script>

<style>
.grafico {
  margin: auto;
}
</style>