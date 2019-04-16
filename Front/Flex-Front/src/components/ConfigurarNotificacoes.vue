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
    <v-form>
      <h3>Configuracoes de Notificacoes</h3>
      <br>
      <h4>Verifique que seu email esta cadastrado corretamente</h4>
      <label>Ativar Notificacoes via email?</label>
      <br>
      <input type="radio" id="sim" value=true v-model="filtro.isNotificationEmail">
      <label for="sim">Sim   </label>
      <input type="radio" id="nao" value=false v-model="filtro.isNotificationEmail">
      <label for="nao">Nao</label>
    <br>  
    <label>Ativar Notificacoes via poup-up?</label>
      <br>
      <input type="radio" id="sim" value=true v-model="filtro.isNotificationModel">
      <label for="sim">Sim   </label>
      <input type="radio" id="nao" value=false v-model="filtro.isNotificationModel">
      <label for="nao">Nao</label>
    <br>
    <br>  
    <div>
    </div>
    <h4>Qual tempo de antecedencia vc quer ser lembrado?</h4>
      <v-flex xs12 md2>
        <v-select
          item-text="text"
          item-value="value"
          v-model="filtro.timeNotificationModal"
          :items="itemsDiferenca"
          label="Periodo de diferenca"
        ></v-select>
      </v-flex>
          <v-flex xs12 md2>
            <v-btn color="success" @click="salvar">Salvar</v-btn>
          </v-flex>
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
      usuario:{},
      itemsDiferenca: [
        { value: 1, text: "1 dia" },
        { value: 7, text: "1 Semana" },
        { value: 10, text: "10 dias" },
        { value: 30, text: "1 mÃªs" },
        { value: 365, text: "1 ano" }
      ],
      filtro: {
        timeNotificationEmail: "",
        timeNotificationModal: "",
        isNotificationModal: "",
        isNotificationEmail: "",
        login: "",
      }
    }
  },
  methods: {
    salvar: function(){
        this.filtro.login = this.usuario.login;
        axios.
        post("/saveConfig", this.filtro)
        .then(response=>{
          if (response.data) {
              this.$router.push({ name: "Menu" });
            } else {
              this.dialogErro3 = true;
            }
        })
        .catch(e=>{
          console.log(e);
            this.dialog = true;
        });
    },
    created: function(){
    let usuario = JSON.parse(localStorage.getItem("flex-site_cthm"));
    this.usuario = usuario
  }
  
  }
}
</script>