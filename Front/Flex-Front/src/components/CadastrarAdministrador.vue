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
    <v-dialog v-model="dialogErro1" width="500">
      <v-card>
        <v-card-title class="headline grey lighten-2" primary-title>Erro</v-card-title>

        <v-card-text>Preencha todos os campos!</v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="warning" flat @click="dialogErro1 = false">Ok</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-dialog v-model="dialogErro2" width="500">
      <v-card>
        <v-card-title class="headline grey lighten-2" primary-title>Erro</v-card-title>

        <v-card-text>As senhas não são iguais!</v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="warning" flat @click="dialogErro2 = false">Ok</v-btn>
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
    <div style="margin: 50px auto; width: 40%; text-align: center;">
      <span>Cadastro do administrador</span>
      <v-form ref="form">
        <v-text-field v-model="usuario.nome" label="Nome" required></v-text-field>
        <v-text-field v-model="usuario.login" label="Login" required></v-text-field>
        <v-text-field v-model="usuario.senha" label="Senha" type="password" required></v-text-field>
        <v-text-field v-model="senha" label="Confirmar Senha" type="password" required></v-text-field>
        <v-select
          v-model="usuario.idSetor"
          :items="items"
          item-text="nome"
          item-value="id"
          label="Setor"
        ></v-select>
        <v-btn color="success" @click="cadastrar">Entrar</v-btn>
      </v-form>
    </div>
  </v-app>
</template>

<script>
import axios from "../axios/client.js";
export default {
  data() {
    return {
      dialog: false,
      dialogErro1: false,
      dialogErro2: false,
      dialogErro3: false,
      items: [],
      senha: "",
      usuario: {
        login: "",
        nome: "",
        senha: "",
        idSetor: ""
      }
    };
  },
  methods: {
    cadastrar: function() {
      if (
        this.usuario.login == "" ||
        this.usuario.nome == "" ||
        this.usuario.senha == "" ||
        this.senha == "" ||
        this.usuario.setor == ""
      ) {
        this.dialogErro1 = true;
      } else if (this.senha != this.usuario.senha) {
        this.dialogErro2 = true;
      } else {
        axios
          .post("usuario/administrador", this.usuario)
          .then(response => {
            if (response.data) {
              this.$router.push({ name: "Login" });
            } else {
              this.dialogErro3 = true;
            }
          })
          .catch(e => {
            console.log(e);
            this.dialog = true;
          });
      }
    }
  },
  created: function() {
    axios
      .get("setores")
      .then(response => {
        this.items = response.data;
      })
      .catch(e => {
        this.dialog = true;
      });
  }
};
</script>
