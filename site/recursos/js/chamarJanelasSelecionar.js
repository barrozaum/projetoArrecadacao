function chamarJanelaBairro() {
    var url = "recursos/includes/selecionar/selecionarBairro.php?janela=1";
    window.open(url, 'galeria', 'width=1024,height=508');
    return false;
}
function chamarJanelaRua() {
    var url = "recursos/includes/selecionar/selecionarRua.php?janela=1";
    window.open(url, 'galeria', 'width=1024,height=508');
    return false;
}
$(document).on('click', '#id_lupa_atividade_contribuinte', function (e) {
    var url = "recursos/includes/selecionar/selecionarAtividade.php?janela=1";
    window.open(url, 'galeria', 'width=1024,height=508');
    return false;
});

