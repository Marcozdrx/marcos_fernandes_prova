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
    
    if (!regexNome.test(nome)) {
        alert("O nome não pode conter números ou caracteres especiais. Use apenas letras, espaços, hífens e apóstrofos.");
        return false;
    }
    
    return true;
}

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
    
    if (!regexNomeCliente.test(nomeCliente)) {
        alert("O nome não pode conter números ou caracteres especiais. Use apenas letras, espaços, hífens e apóstrofos.");
        return false;
    }
    
    return true;
}

function validarFormularioCliente() {
    let nomeCliente = document.getElementById("nome_cliente").value;
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
function validarTelefone(telefone) {
    // Remove formatação
    let telefoneCliente = document.getElementById("telefone").value;
    const telefoneLimpo = telefone.replace(/\D/g, '');
    
    // Verifica comprimento
    if (telefoneCliente.length < 10 || telefoneLimpo.length > 11) {
        return false;
    }
    
    // Verifica DDD
    const ddd = parseInt(telefoneLimpo.substring(0, 2));
    if (ddd < 11 || ddd > 99) {
        return false;
    }
    
    return true;
}
const telefone = document.getElementById("telefone");

telefone.addEventListener("input", function(){
    let valor = telefone.value.replace(/\D/g, ""); //Remove tudo o que nao for numero
    if(valor.length > 10){
        valor = valor.replace(/^(\d{2})(\d{5})(\d{4}).*/, "($1)$2-$3")
    }else if(valor.length > 5){
        valor = valor.replace(/^(\d{2})(\d{4})(\d{0,4}).*/, "($1)$2-$3")
    }else if(valor.length > 2){
        valor = valor.replace(/^(\d{2})(\d{0,5})/, "($1)$2")
    }else{
        valor = valor.replace(/^(\d*)/, "($1")
    }

    telefone.value = valor

})