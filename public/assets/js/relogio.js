function atualizarRelogio() {
    const agora = new Date();
    const data = agora.toLocaleDateString('pt-BR', { day: '2-digit', month: '2-digit', year: 'numeric' });
    document.getElementById('relogio').textContent = `${data} - ${agora.toLocaleTimeString('pt-BR')}`;
}
setInterval(atualizarRelogio, 1000);
atualizarRelogio();
