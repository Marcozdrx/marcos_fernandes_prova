function validarFuncionario() {
    let nome = document.getElementById("nome_funcionario").value;
    let telefone = document.getElementById("telefone").value;
    let email = document.getElementById("email").value;

    if (nome.length < 3) {
        alert("O nome do funcionário deve ter pelo menos 3 caracteres.");
        return false;
    }

    let regexTelefone = /^[0-9]{10,11}$/;
    if (!regexTelefone.test(telefone)) {
        alert("Digite um telefone válido (10 ou 11 dígitos).");
        return false;
    }

    let regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!regexEmail.test(email)) {
        alert("Digite um e-mail válido.");
        return false;
    }

    return true;
}

//Função para validar o nome do usuario
function validarNomeUsuario() {
    let nome = document.getElementById("nome").value;
    
    // Remove espaços em branco no início e fim
    nome = nome.trim();
    
    // Verifica se o nome tem pelo menos 2 caracteres
    if (nome.length < 2) {
        alert("O nome deve ter pelo menos 2 caracteres.");
        return false;
    }
    
    // Regex que permite apenas letras (incluindo acentos), espaços e hífens
    let regexNome = /^[a-zA-ZÀ-ÿ\s\-']+$/;
    
    //Alerta para o usuario indicando o que está errado
    if (!regexNome.test(nome)) {
        alert("O nome não pode conter números ou caracteres especiais. Use apenas letras, espaços, hífens e apóstrofos.");
        return false;
    }
    
    return true;
}


//Função para validar o nome do cliente
function validarNomeCliente() {
    let nomeCliente = document.getElementById("nome_cliente").value;
    
    // Remove espaços em branco no início e fim
    nomeCliente = nomeCliente.trim();
    
    // Verifica se o nome tem pelo menos 2 caracteres
    if (nomeCliente.length < 2) {
        alert("O nome deve ter pelo menos 2 caracteres.");
        return false;
    }
    
    // Regex que permite apenas letras (incluindo acentos), espaços e hífens
    let regexNomeCliente = /^[a-zA-ZÀ-ÿ\s\-']+$/;
    
     //Alerta para o usuario indicando o que está errado
    if (!regexNomeCliente.test(nomeCliente)) {
        alert("O nome não pode conter números ou caracteres especiais. Use apenas letras, espaços, hífens e apóstrofos.");
        return false;
    }
    
    return true;
}

// Função para validar o formulario do cliente, com o email e nome
function validarFormularioCliente() {
    let email_cliente = document.getElementById("email").value;
    
    // Valida o nome
    if (!validarNomeUsuario()) {
        return false;
    }
    
    // Valida o email
    let regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!regexEmail.test(email_cliente)) {
        alert("Digite um e-mail válido.");
        return false;
    }
    
    
    return true;
}

// Função para validar o telefone
function validarTelefone(telefone) {
    // Remove formatação
    let telefoneCliente = document.getElementById("telefone").value;
    const telefoneLimpo = telefone.replace(/\D/g, '');
    
    // Verifica comprimento se for menor que 10
    if (telefoneCliente.length < 10 || telefoneLimpo.length > 11) {
        return false;
    }
    
    // Verifica DDD para nao ser inexistente
    const ddd = parseInt(telefoneLimpo.substring(0, 2));
    if (ddd < 11 || ddd > 99) {
        return false;
    }
    
    return true;
}

//Codigo para adicionar mascara no campo telefone
const telefone = document.getElementById("telefone");

telefone.addEventListener("input", function(){
    let valor = telefone.value.replace(/\D/g, ""); //Remove tudo o que nao for numero
    // Adiconiona a mascara de acordo com a quantidade de caracteres(numeros)
    if(valor.length > 10){
        valor = valor.replace(/^(\d{2})(\d{5})(\d{4}).*/, "($1)$2-$3")
    }else if(valor.length > 5){
        valor = valor.replace(/^(\d{2})(\d{4})(\d{0,4}).*/, "($1)$2-$3")
    }else if(valor.length > 2){
        valor = valor.replace(/^(\d{2})(\d{0,5})/, "($1)$2")
    }else{
        valor = valor.replace(/^(\d*)/, "($1")
    }

    // Atribui os dados do telefone a variavel valor
    telefone.value = valor

})