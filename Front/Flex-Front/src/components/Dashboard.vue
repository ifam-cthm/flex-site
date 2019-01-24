<template>
  <v-container>
    <apexchart style="margin: auto;" width="700" type="bar" :options="options" :series="series"></apexchart>
  </v-container>
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
      grafico: {
        usuarios: [],
        quantidades: []
      },
      options: {},
      series: []
    };
  },
  mounted: function() {
    axios
      .get("grafico")
      .then(response => {
        this.grafico = response.data;
        (this.options = {
          chart: {
            id: "grafico"
          },
          xaxis: {
            categories: this.grafico.usuarios
          }
        }),
          (this.series = [
            { name: "Quantidade de documentos", data: this.grafico.quantidades }
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