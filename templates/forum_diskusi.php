<div class="position-relative">
    <div class="chat-messages p-4" id="chat-messages">
    </div>
</div>

<div class="flex-grow-0 py-3 px-4 border-top">
    <form action="">
        <div class="input-group">
            <input type="text" id="pesan" class="form-control" placeholder="Type your message">
            <button type="submit" class="btn btn-primary" id="kirim-pesan">Send</button>
        </div>
    </form>
</div>
<script>
    const id_user = JSON.parse('<?= json_encode($_SESSION['user']['id_user']); ?>');
    const chatMessages = document.getElementById('chat-messages');

    const pesan = document.getElementById('pesan');
    const urlParams = new URLSearchParams(window.location.search);


    const chatMessage = (chat) => {
        return `
            <div class="chat-message-${chat.id_user == id_user ? 'right' : 'left'} pb-4">
                <div>
                    <img src="${chat.foto_guru || chat.foto_siswa}" onerror="imageError(this)" class="rounded-circle me-1" alt="Sharon Lessman" width="40" height="40">
                    <div class="text-muted small text-nowrap text-center mt-2">${(chat.jam).padStart(2, "0")}:${(chat.menit).padStart(2, "0")}</div>
                </div>
                <div class="flex-shrink-1 bg-light rounded py-2 px-3 m${chat.id_user == id_user ? 'e' : 's'}-3">
                    <div class="font-weight-bold mb-1">${chat.id_user == id_user ? 'Anda' : (chat.nama_guru || chat.nama_siswa)}</div>
                    ${chat.pesan}
                </div>
            </div>
        `;
    }
    const updateChat = async () => {
        const response = await fetch(`ajax/forum_diskusi.php?id=${urlParams.get('id')}`);
        const data = await response.json();
        chatMessages.innerHTML = '';
        console.log(data)
        data.forEach(datum => {
            chatMessages.insertAdjacentHTML('beforeend', chatMessage(datum));
        });
    }
    updateChat();
    document.querySelector('form').addEventListener('submit', async (e) => {
        e.preventDefault();
        if (pesan.value) {
            const response = await fetch(`ajax/send_message.php?id=${urlParams.get('id')}&pesan=${pesan.value}&id_user=${id_user}`);
            pesan.value = '';
        }
        updateChat();
    })
</script>