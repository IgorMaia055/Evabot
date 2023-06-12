$(document).ready(function (){
    $('#enviar').click(function (){
        var busca = $('#mensagem').val();
        $('#mensagem').val('')

        $('#modalBody').append('<div class="toast mesageUser">'+
          '<div class="toast-header">'+
            '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle rounded me-2" viewBox="0 0 16 16">'+
            '<path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>'+
            '<path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>'+
          '</svg>'+
            '<strong class="me-auto">Você</strong>'+
            '<small>' + new Date().getHours().toString().padStart(2, '0') + ':' + new Date().getMinutes().toString().padStart(2, '0')
        +'</small>'+
          '</div>'+
          '<div class="toast-body">'+
            busca 
          +'</div>'+
        '</div>')
        descerscroll()

        if(busca.length > 0){

          document.querySelector('.eye-left').hidden = true
          document.querySelector('.eye-right').hidden = true
          document.getElementById('sppiner').hidden = false

          $('#modalBody').append('<div class="toast mesageEva" id="carregamento">'+
                    '<div class="toast-header">'+
                      '<img src="../site/img/2023-05-28 (2).png" width="20" height="20" class="rounded me-2" alt="...">'+
                      '<strong class="me-auto">Evabot</strong>'+
                    '</div>'+
                    '<div class="toast-body">'+
                      '<img src="../site/img/icons8-pontos.gif" width="30" height="30" alt="">'+
                    '</div>'+
                  '</div>')
                  descerscroll()
            $.ajax({
                url: "{{ url('chatGpt/') }}",
                method: 'POST',
                data: {
                    'mensagem': busca   
                },
                success: function (data) {
                  let mensageEvaBot
                  if(data != ''){
                    mensageEvaBot = data.replace('Eu:', '').replace('(a)', '').replace('/a', '')
                  }else{
                    mensageEvaBot = 'Desculpe, Aconteceu um erro temporário.'
                  }

                  $('#modalBody').append('<div class="toast mesageEva">'+
                    '<div class="toast-header">'+
                      '<img src="../site/img/2023-05-28 (2).png" width="20" height="20" class="rounded me-2" alt="...">'+
                      '<strong class="me-auto">Evabot</strong>'+
                      '<small>' + new Date().getHours().toString().padStart(2, '0') + ':' + new Date().getMinutes().toString().padStart(2, '0')
        +'</small>'+
                    '</div>'+
                    '<div class="toast-body">'+
                      mensageEvaBot 
                    +'</div>'+
                  '</div>')
                  descerscroll()

                  readOutLoud(mensageEvaBot)
                  
                  document.querySelector('.eye-left').hidden = false
                  document.querySelector('.eye-right').hidden = false
                  document.getElementById('sppiner').hidden = true

                  let element = document.getElementById('carregamento')
                  element.parentNode.removeChild(element)
                }
            })
        }
    })

  })

function readOutLoud(message) {
  var utter = new SpeechSynthesisUtterance(message); // responsável pelo que vai falar!
  let vozSelect = $("#vozes").val($('option:contains("Google português do Brasil (pt-BR)")').val());
  if(vozSelect.val() == "19"){
    utter.voice = voices[vozSelect.val()];
  }else{
    let vozSelect2 = $("#vozes").val($('option:contains("Microsoft Francisca Online (Natural) - Portuguese (Brazil) (pt-BR)")').val());
    utter.voice = voices[vozSelect2.val()];
    console.log(vozSelect2.val())
  }
}

  const synth = window.speechSynthesis; // chamada SpeechSynthesis API
  const selectVoices = document.querySelector('select'); // lista de vozes

let voices = [];
function getVoices() { 
  voices = synth.getVoices(); // armazena as vozes no array
  voices.forEach((voice, index) => {
    selectVoices.add(new Option(`${voice.name} (${voice.lang})`, index)); // adiciona as informações na lista de seleção..
  });
}

window.addEventListener('load', () => { // ao ser concluído..
  getVoices(); // carrega as vozes..
  if (synth.onvoiceschanged !== undefined)
    synth.onvoiceschanged = getVoices; // checa e atualiza o evento
});

function descerscroll(){
  $("#modalBody").scrollTop($("#modalBody")[0].scrollHeight)
}

function tamanhoTela(){
  let largura = window.screen.width
  let altura = window.screen.height

  if(largura <= 500){
    document.querySelector('.eva').style.animation = 'floor2 3s infinite'
    document.querySelector('.modal-dialog').style.position = 'fixed'
    document.querySelector('.modal-dialog').style.marginTop = '5rem'
  }else{
    document.querySelector('.eva').style.animation = 'floor 3s infinite'
    document.querySelector('.modal-dialog').style.position = ''
    document.querySelector('.modal-dialog').style.marginTop = ''
  }

  if(altura <= 500){
    document.querySelector('.aviso').hidden = false
  }else{
    document.querySelector('.aviso').hidden = true
  }
}

setInterval(() => {
  tamanhoTela()
}, 1000);
