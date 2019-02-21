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
    <v-dialog v-model="dialogErro3" width="500">
      <v-card>
        <v-card-title class="headline grey lighten-2" primary-title>Erro</v-card-title>

        <v-card-text>Erro ao cadastrar o tipo.</v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" flat @click="dialogErro3= !dialogErro3">Ok</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <div style="margin: 50px auto; width: 40%; text-align: center;">
      <span>{{title}}</span>
      <v-form ref="form">
        <v-text-field v-model="tipo.nome" label="Nome" required></v-text-field>
        <v-text-field v-model="tipo.descricao" label="Descrição"></v-text-field>
        <v-btn v-if="cadastro" color="success" @click="cadastrar">Cadastrar</v-btn>
        <v-btn v-else color="success" @click="alterar">Alterar</v-btn>
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
      title: "",
      cadastro: true,
      tipo: {
        nome: "",
        bloqueado: null,
        id: null
      }
    };
  },
  methods: {
    cadastrar() {
      if (this.tipo.nome == "") {
        this.dialogErro1 = true;
      } else {
        axios
          .post("tipos", this.tipo)
          .then(response => {
            if (response.data) {
              this.$router.push({ name: "ListarTipos" });
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
    alterar() {
      if (this.tipo.nome == "" || this.tipo.bloqueado == null) {
        this.dialogErro1 = true;
      } else {
        axios
          .put("tipos/" + this.tipo.id, this.tipo)
          .then(response => {
            if (response.data) {
              this.$router.push({ name: "ListarTipos" });
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
      .get("tipos")
      .then(response => {
        this.items = response.data;
      })
      .catch(e => {
        this.dialog = true;
      });
    if (this.$route.params.id) {
      this.title = "Editar tipo";
      this.cadastro = false;
      axios
        .get("tipos/" + this.$route.params.id)
        .then(response => {
          this.tipo = response.data[0];
        })
        .catch(e => {});
    } else {
      this.title = "Novo tipo";
      this.cadastro = true;
    }
  }
};
</script>