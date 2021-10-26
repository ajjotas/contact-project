var helpers = {
  montaMensagemDeErroAPI: function(data) {
    if (data.errors) {
      let listaErros = '<ul>';
      Object.entries(data.errors).forEach(([key, error]) => {
        listaErros += '<li>' + error + '</li>';
      });
      listaErros += '</ul>';

      return listaErros;
    } else {
      return data.message;
    }
  },

  apenasDigitos: function(value) {
    return value.replace(/[^\d]+/g,'');
  }

};

helpers = Object.freeze(helpers);
export default helpers;
