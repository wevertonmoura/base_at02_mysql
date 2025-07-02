// === Menu hambúrguer (responsividade) ===
document.addEventListener('DOMContentLoaded', () => {
    const hamburger = document.getElementById('hamburger');
    const navMenu = document.getElementById('nav-menu');
  
    if (hamburger && navMenu) {
      hamburger.addEventListener('click', () => {
        navMenu.classList.toggle('show');
      });
    }
  });
  
  // === Validação extra de formulário de cadastro ===
  const formCadastro = document.getElementById('formCadastro');
  
  if (formCadastro) {
    formCadastro.addEventListener('submit', function (e) {
      e.preventDefault();
  
      const nome = formCadastro.nome.value.trim();
      const email = formCadastro.email.value.trim();
      const telefone = formCadastro.telefone.value.trim();
      const senha = formCadastro.senha.value.trim();
  
      // Validações simples
      if (nome.length < 3) {
        alert('O nome deve ter no mínimo 3 caracteres.');
        formCadastro.nome.focus();
        return;
      }
  
      if (!email.includes('@') || !email.includes('.')) {
        alert('E-mail inválido.');
        formCadastro.email.focus();
        return;
      }
  
      if (!/^\d{11}$/.test(telefone)) {
        alert('Telefone deve conter 11 dígitos. Ex: 81999999999');
        formCadastro.telefone.focus();
        return;
      }
  
      if (senha.length < 6) {
        alert('A senha deve ter no mínimo 6 caracteres.');
        formCadastro.senha.focus();
        return;
      }
  
      // Se passou na validação, envia
      formCadastro.submit();
    });
  }
  