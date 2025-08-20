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

function validarFormularioUsuario() {
    let nome = document.getElementById("nome").value;
    let email = document.getElementById("email").value;
    let senha = document.getElementById("senha").value;
    
    // Valida o nome
    if (!validarNomeUsuario()) {
        return false;
    }
    
    // Valida o email
    let regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!regexEmail.test(email)) {
        alert("Digite um e-mail válido.");
        return false;
    }
    
    // Valida a senha (mínimo 6 caracteres)
    if (senha.length < 6) {
        alert("A senha deve ter pelo menos 6 caracteres.");
        return false;
    }
    
    return true;
}