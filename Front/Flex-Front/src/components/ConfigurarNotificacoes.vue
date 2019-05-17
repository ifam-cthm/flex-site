<template>
  <v-app>
    <v-dialog v-model="dialog" width="500">
      <v-card>
        <v-card-title class="headline grey lighten-2" primary-title>Erro</v-card-title>
        <v-card-text>Erro ao acessar o serviços. Contate o administrador, por favor!</v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" flat @click="dialog = false">Ok</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-dialog v-model="dialogErro3" width="500">
      <v-card>
        <v-card-title class="headline grey lighten-2" primary-title>Erro</v-card-title>

        <v-card-text>Erro ao cadastrar o usuário.</v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" flat @click="dialogErro3= !dialogErro3">Ok</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <div>
      <v-form style="margin: 10pt; text-align: center;">
        <h2>Configurações de Notificações</h2>
        <br>
        <v-flex>
          <v-select
            item-text="nome"
            item-value="id"
            v-model="search"
            label="Tipo"
            :items="itemsTipos"
          ></v-select>
        </v-flex><v-btn color="success" @click="procurarTipos">Procurar</v-btn>
        <br>
        <h4>Verifique se seu email está cadastrado corretamente</h4>
        <label>Ativar notificações via email?</label>
        <br>
        <input type="radio" id="simEmail" value="true" v-model="filtro.isNotificationEmail">
        <label for="simEmail">Sim</label>
        <input type="radio" id="naoEmail" value="false" v-model="filtro.isNotificationEmail">
        <label for="naoEmail">Nao</label>
        <br>
        <label>Ativar Notificacoes via poup-up?</label>
        <br>
        <input type="radio" id="simModal" value="true" v-model="filtro.isNotificationModal">
        <label for="simModal">Sim</label>
        <input type="radio" id="naoModal" value="false" v-model="filtro.isNotificationModal">
        <label for="naoModal">Nao</label>
        <br>
        <br>
        <div></div>
        <h4>As notificações devem começa a aparecer a partir de?(Digite o tempo em dias)</h4>
        <v-flex>
          <v-text-field v-model="filtro.time" label="Tempo" required></v-text-field>
        </v-flex>
        <v-btn color="success" @click="salvar">Salvar</v-btn>
      </v-form>
    </div>
  </v-app>
</template>

<script>
import axios from "../axios/client.js";
export default {
  name: "",
  data() {
    return {
      checked: false,
      dialogErro3: false,
      dialog: false,
      search:null,
      tipo: {},
      filtro: {
        time: null,
        isNotificationModal: "",
        isNotificationEmail: "",
        id: ""
      },
      itemsTipos: []
    };
  },
  methods: {
    salvar: function() {
      this.filtro.id = this.tipo.id;
      axios
        .post("/saveConfig", this.filtro)
        .then(response => {
          if (response.data) {
            this.$router.push({ name: "Menu" });
          } else {
            this.dialogErro3 = true;
          }
        })
        .catch(e => {
          console.log(e);
          this.dialog = true;
        });
    },
    procurarTipos: function()  {
      axios
        .get("tipos/" + this.search)
        .then(response => {
          this.tipo = response.data[0];
          this.filtro.isNotificationModal =
            this.tipo.isNotificationModal == "1" ? true : false;

          this.filtro.isNotificationEmail =
            this.tipo.isNotificationEmail == "1" ? true : false;

          this.filtro.time = parseInt(this.tipo.timeNotificationEmail);
        })
        .catch(e => {
          console.log(e);
        });
    }
  },
  created: function() {
    //this.usuario = usuario;
    axios
      .get("tipos")
      .then(response => {
        this.itemsTipos = response.data;
      })
      .catch(e => {});
  }
};
</script>