<template>
  <b-container>

    <div class="text-center">
      <h2 class="mt-5 text-success">Cadastro de contato</h2>
    </div>
    
      <b-card title="Preencha seus dados">

        <b-alert 
          variant="success" 
          :show="successMessage ? true : false"
        >{{successMessage}}</b-alert> 
        <b-alert 
          variant="danger" 
          :show="errorMessage ? true : false"
          v-html="errorMessage"
        ></b-alert>  

        <b-form-group 
          label="Nome" 
          label-for="nome"
        >
          <b-form-input 
            maxlength="100" 
            id="nome" 
            v-model="nome" 
            trim
          ></b-form-input>
        </b-form-group>     

        <b-form-group 
          label="E-mail" 
          label-for="email"
        >
          <b-form-input
            maxlength="100" 
            id="email" 
            v-model="email" 
            trim
          ></b-form-input>
        </b-form-group>  

        <b-form-group 
          label="Telefone" 
          label-for="telefoneFormatado"
        >
          <b-form-input  
            id="telefoneFormatado" 
            v-model="telefoneFormatado" 
            trim
            v-mask="['(##) ####-####', '(##) #####-####']"
          ></b-form-input>
        </b-form-group>                   

        <b-form-group 
          label="Mensagem" 
          label-for="mensagem"
        >
          <b-form-textarea
            id="mensagem"
            v-model="mensagem"
            rows="3"
            maxlength="400"            
          ></b-form-textarea>          
        </b-form-group>

        <b-form-group label="Arquivo anexo">
          <b-form-file 
            v-model="arquivo" 
            plain
          ></b-form-file>
        </b-form-group>  

        <b-button
          class= "mt-3"
          squared 
          variant="success" 
          @click="adicionaContato"
        >Adiciona o contato</b-button>   

      </b-card>
 
    <div class="text-center">
      <h4 class= "mt-5">Netshow.me - Teste técnico</h4>
      <h5 class= "text-muted">Bruno Araújo - 2021</h5>   
    </div>     
  </b-container>
</template>

<script>

export default {
  name: 'Home',
  
  data() {
    return {
      nome: '',      
      email: '',
      telefoneFormatado: '',      
      mensagem: '',
      arquivo: [],

      errorMessage: '',
      successMessage: '',
    }
  },

  computed: {
    telefone() {
      return this.$h.apenasDigitos(this.telefoneFormatado); 
    }
  },

  methods: {
    adicionaContato() { 
      this.limpaMensagens();     
      if (this.camposValidos()) {
        let data = this.montaFormData();
        let config = this.montaConfig();
        this.enviaRequisicao('contato/add', data, config);    
      } 
    },

    limpaMensagens() {
      this.successMessage = '';
      this.errorMessage = '';
    },

    camposValidos() {
      if (!this.nome || !this.email || !this.telefone || !this.mensagem || !this.arquivo) {
        this.errorMessage = "Todos os campos devem ser preenchidos."
        return false;
      }
      if (this.telefone.length < 10 || this.telefone.length > 11) {
        this.errorMessage = "O telefone deve ser preenchido com 10 ou 11 dígitos."
        return false;      
      }
      return true;
    },

    montaFormData() {
      let data = new FormData();
      data.append('nome', this.nome);
      data.append('email', this.email);
      data.append('telefone', this.telefone);
      data.append('mensagem', this.mensagem);
      data.append('arquivo', this.arquivo);  

      return data;
    },

    montaConfig() {
      return {
        headers: {
          'content-type': 'multipart/form-data'
        }
      };
    },

    enviaRequisicao(url, data, config) {
      this.$http.post(url, data, config)
        .then((response) => {  
          this.limpaCampos();
          this.successMessage = response.data.success; 
        })
        .catch((response) => {
          this.errorMessage = this.$h.montaMensagemDeErroAPI(response.response.data);          
        }); 
    },  

    limpaCampos() {
      this.nome =  '';
      this.email = '';
      this.telefoneFormatado = '';
      this.mensagem = '';
      this.arquivo = [];     
    },  
  }  
}
</script>
