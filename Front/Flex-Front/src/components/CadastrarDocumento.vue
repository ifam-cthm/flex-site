<template>
  <v-app>
    <v-dialog v-model="dialog" width="500">
      <v-card>
        <v-card-title class="headline grey lighten-2" primary-title>Atenção</v-card-title>
        <v-card-text>Erro ao cadastrar um novo documento. Contate o administrador, por favor!</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" flat @click="cadastrar">Ok</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog v-model="dialogErro" width="500">
      <v-card>
        <v-card-title class="headline grey lighten-2" primary-title>Erro</v-card-title>
        <v-card-text>Erro ao acessar o serviços. Contate o administrador, por favor!</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" flat @click="dialogErro = !dialogErro">Ok</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog v-model="dialogErro1" width="500">
      <v-card>
        <v-card-title class="headline grey lighten-2" primary-title>Erro</v-card-title>
        <v-card-text>Erro ao realizar login.</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" flat @click="dialogErro1= !dialogErro1">Ok</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-container>
      <v-card>
        <v-card-title class="display-1">Novo documento</v-card-title>
        <v-card-text>
          <v-form ref="form">
            <v-container>
              <v-layout>
                <v-flex xs12 md6>
                  <v-text-field v-model="documento.nome" label="Nome" required></v-text-field>
                </v-flex>
                <v-flex xs12 md6>
                  <v-autocomplete
                    v-model="responsavel.loginUsuario"
                    :items="itemsResponsaveis"
                    item-text="nome"
                    item-value="login"
                    label="Responsável(opcional)"
                  ></v-autocomplete>
                </v-flex>
              </v-layout>
              <v-layout row wrap>
                <v-flex xs12 md4>
                  <v-select
                    item-text="nome"
                    item-value="id"
                    v-model="documento.setor"
                    label="Setor"
                    :items="itemsSetores"
                  ></v-select>
                </v-flex>

                <v-flex xs12 md4>
                  <v-select
                    item-text="nome"
                    item-value="id"
                    v-model="documento.tipo"
                    label="Tipo"
                    :items="itemsTipos"
                  ></v-select>
                </v-flex>

                <v-flex xs12 md4>
                  <v-text-field
                    v-model="documento.dataVencimento"
                    label="Data Vencimento"
                    type="date"
                    required
                  ></v-text-field>
                </v-flex>
              </v-layout>
              <v-btn color="success" @keyup.enter="cadastrar" @click="cadastrar">Cadastrar</v-btn>
            </v-container>
          </v-form>
        </v-card-text>
      </v-card>
    </v-container>
  </v-app>
</template>

<script>
import axios from "../axios/client.js";
export default {
  data() {
    return {
      dialog: false,
      dialogErro: false,
      dialogErro1: false,
      logando: false,
      documento: {
        nome: "",
        setor: "",
        tipo: "",
        dataVencimento: "",
        bloqueado: false
      },
      itemsSetores: [],
      itemsTipos: [],
      itemsResponsaveis: [],
      responsavel: {
        loginUsuario: "",
        idDocumento: ""
      }
    };
  },
  methods: {
    cadastrar() {
      if (
        this.documento.nome == "" ||
        this.documento.setor == "" ||
        this.documento.tipo == "" ||
        this.documento.dataVencimento == ""
      ) {
        dialogErro = true;
      } else {
        axios
          .post("documento", this.documento)
          .then(response => {
            if (response.data) {
              this.responsavel.idDocumento = response.data["id"];
            } else {
            }
          })
          .catch(e => {
            console.log(e);
            this.dialogErro = true;
          });
        if (
          this.responsavel.loginUsuario != "" &&
          this.responsavel.idDocumento != ""
        ) {
          axios
            .post("responsavel", this.responsavel)
            .then(response => {
              if (response.data) {
                this.$router.push({ name: "DocumentosVencidos" });
              } else {
              }
            })
            .catch(e => {
              console.log(e);
              this.dialogErro = true;
            });
        }
      }
    }
  },

  created: function() {
    axios
      .get("setores")
      .then(response => {
        this.itemsSetores = response.data;
      })
      .catch(e => {});
    axios
      .get("responsaveis")
      .then(response => {
        this.itemsResponsaveis = response.data;
      })
      .catch(e => {});
    axios
      .get("tipos")
      .then(response => {
        this.itemsTipos = response.data;
      })
      .catch(e => {});
  }
};
</script>