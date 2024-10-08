let onlineUsers = [];

Echo.join("chat")
    .here(handleHereUsers)
    .joining(handleUserJoining)
    .leaving(handleUserLeaving)
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
        changeUserStatus(user.username, "آنلاین", "show");
    });
}

function handleUserJoining(user) {
    changeUserStatus(user.username, "آنلاین", "show");
}

function handleUserLeaving(user) {
    changeUserStatus(user.username, "", "hidde");
}

function changeUserStatus(username, status = "", elStatus, push = true) {
    let memberStatus = document.getElementById(`member-status-${username}`)

    if (memberStatus) {
        if (elStatus === "show") {
            if (push) {
                onlineUsers.push(username);
            }
        } else if (elStatus === "hidde") {
            let index = onlineUsers.indexOf(username);

            if (index !== -1) {
                onlineUsers.splice(index, 1);
            }
        }

        let firstElementChild = memberStatus.firstElementChild;

        firstElementChild.innerHTML = status;

        if (elStatus === "show") {
            firstElementChild.classList.remove("hidden");
        } else if (elStatus === "hidde") {
            firstElementChild.classList.add("hidden");
        }
    }
}

document.addEventListener('livewire:navigated', (event) => {
    onlineUsers.forEach(function (username) {
        changeUserStatus(username, "آنلاین", "show", false);
    });
});
