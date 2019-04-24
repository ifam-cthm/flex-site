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
        <h4>As notificações devem começa a aparecer a partir de?</h4>
        <v-layout align-center justify-center row fill-height>
          <v-flex xs1>
            <v-select
              item-text="text"
              item-value="value"
              v-model="filtro.time"
              :items="itemsDiferenca"
            ></v-select>
          </v-flex>
        </v-layout>
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
      usuario: {},
      itemsDiferenca: [
        { value: 1, text: "1 dia" },
        { value: 7, text: "1 Semana" },
        { value: 10, text: "10 dias" },
        { value: 30, text: "1 mês" },
        { value: 365, text: "1 ano" }
      ],
      filtro: {
        time: 30,
        isNotificationModal: "",
        isNotificationEmail: "",
        login: ""
      }
    };
  },
  methods: {
    salvar: function() {
      this.filtro.login = this.usuario.login;
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
    }
  },
  created: function() {
    let usuario = JSON.parse(localStorage.getItem("flex-site_cthm"));
    axios
      .get("usuario/" + usuario.login)
      .then(response => {
        this.usuario = response.data[0];
        this.filtro.isNotificationModal =
          this.usuario.isNotificationModal == "1" ? true : false;

        this.filtro.isNotificationEmail =
          this.usuario.isNotificationEmail == "1" ? true : false;

        this.filtro.time = parseInt(this.usuario.timeNotificationEmail);
      })
      .catch(e => {
        console.log(e);
      });
    //this.usuario = usuario;
  }
};
</script>