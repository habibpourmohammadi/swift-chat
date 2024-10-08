let onlineUsers = [];

Echo.join("chat")
    .here(handleHereUsers)
    .joining(handleUserJoining)
    .listenForWhisper("memberTyping", handleMemberTyping);

function handleMemberTyping(e) {
    let memberStatus = document.getElementById(`member-status-${e.chatUuid}`);

    if (memberStatus != null) {
        setTimeout(() => {
            memberStatus.classList.add("hidden");

            let memberUsername = memberStatus.parentElement.id.split("-")[2];

            if (onlineUsers.includes(memberUsername)) {
                memberStatus.classList.remove("hidden");
                memberStatus.innerText = "آنلاین";
            }

        }, 2000);

        memberStatus.classList.remove("hidden");
        memberStatus.innerText = "در حال نوشتن";
    }
}

function handleHereUsers(users) {
    users.forEach(function (user) {
        changeUserStatus(user, "آنلاین", "show");
    });
}

function handleUserJoining(user) {
    changeUserStatus(user, "آنلاین", "show");
}

function changeUserStatus(user, status = "", elStatus) {
    let memberStatus = document.getElementById(`member-status-${user.username}`)

    if (memberStatus) {
        onlineUsers.push(user.username);

        let firstElementChild = memberStatus.firstElementChild;

        firstElementChild.innerHTML = status;

        if (elStatus === "show") {
            firstElementChild.classList.remove("hidden");
        } else if (elStatus === "hidde") {
            firstElementChild.classList.add("hidden");
        }
    }
}
