Echo.join("chat")
    .listenForWhisper("memberTyping", handleMemberTyping);

function handleMemberTyping(e) {
    let memberStatus = document.getElementById(`member-status-${e.chatUuid}`);

    if (memberStatus != null) {
        console.log(memberStatus);

        setTimeout(() => {
            memberStatus.classList.add("hidden");
        }, 2000);

        memberStatus.classList.remove("hidden");
        memberStatus.innerText = "در حال نوشتن";

    }
}
