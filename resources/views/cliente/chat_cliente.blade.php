
@include('layouts.header_cliente')
<style>

/* MAIN */
.main{
  flex:1;
  padding:20px;
  display:flex;
  flex-direction:column;
}

/* HEADER */
.topbar{
  display:flex;
  justify-content:space-between;
  align-items:center;
  margin-bottom:15px;
}

.topbar h2{
  color:#6c3ce9;
}

.search{
  padding:10px 15px;
  border-radius:20px;
  border:1px solid #ddd;
  width:250px;
}

/* CHAT LAYOUT */
.chat-container{
  display:grid;
  grid-template-columns:1fr;
}

/* USERS LIST */
.users{
  background:#fff;
  border-radius:12px;
  padding:15px;
  overflow-y:auto;
}

.user-item{
  display:flex;
  align-items:center;
  gap:10px;
  padding:10px;
  border-radius:10px;
  cursor:pointer;
}

.user-item:hover{
  background:#f5f5ff;
}

.avatar{
  width:40px;height:40px;
  border-radius:50%;
  background:#ddd;
}

.user-name{
  font-size:14px;
}

.user-sub{
  font-size:12px;
  color:#888;
}

/* CHAT BOX */
.chat-box{
  background:#fff;
  border-radius:12px;
  display:flex;
  flex-direction:column;
  padding:15px;
}

/* MESSAGES */
.messages{
  flex:1;
  overflow-y:auto;
  padding:10px;
}

.message{
  display:flex;
  margin-bottom:15px;
}

.message.left{
  justify-content:flex-start;
}

.message.right{
  justify-content:flex-end;
}

.bubble{
  max-width:60%;
  padding:12px;
  border-radius:12px;
  font-size:13px;
}

.left .bubble{
  border:2px solid #6c3ce9;
  color:#555;
}

.right .bubble{
  background:#f1f1f1;
}

.time{
  font-size:11px;
  color:#999;
  margin-top:5px;
}

/* INPUT */
.chat-input{
  border-top:1px solid #eee;
  padding:10px;
}

.chat-input input{
  width:100%;
  padding:12px;
  border-radius:10px;
  border:1px solid #ddd;
}
.badge{
    background:red;
    color:white;
    border-radius:20px;
    padding:2px 6px;
    font-size:11px;
    margin-left:5px;
}

</style>


<!-- MAIN -->
<div class="main">

  <div class="topbar">
    <h2>Chat</h2>
    <input class="search" placeholder="Search anything here...">
  </div>

  <div class="chat-container">

   
    

    <!-- CHAT -->
    <div class="chat-box">

      <div class="messages" id="messages">

      </div>

      <div class="chat-input">
        <input id="txtMensaje" placeholder="Write a message...">
      </div>

    </div>

  </div>

</div>

</div>

</body>
<script>

const ADMIN_ID = 1;

function cargarMensajes()
{
    fetch('mensajes/'+ADMIN_ID)
    .then(r=>r.json())
    .then(data=>{

        let html='';

        data.forEach(m=>{

            let lado=
                m.id_emisor=={{ session('usuario_id') }}
                ?'right'
                :'left';

            html+=`
            <div class="message ${lado}">
                <div>

                    <div class="bubble">
                        ${m.mensaje}
                    </div>

                    <div class="time">
                        ${m.created_at}
                    </div>

                </div>
            </div>`;
        });

        document.getElementById('messages').innerHTML=html;

        let box=document.getElementById('messages');

        box.scrollTop=box.scrollHeight;

    });
}

document
.getElementById('txtMensaje')
.addEventListener('keypress',function(e){

    if(e.key=='Enter'
       && this.value.trim()!=''){

        fetch('enviar',{

            method:'POST',

            headers:{
                'Content-Type':'application/json',
                'X-CSRF-TOKEN':'{{ csrf_token() }}'
            },

            body:JSON.stringify({

                id_receptor:ADMIN_ID,
                mensaje:this.value

            })

        })
        .then(r=>r.json())
        .then(()=>{

            this.value='';

            cargarMensajes();

        });

    }

});

cargarMensajes();

setInterval(cargarMensajes,2000);

</script>
</html>