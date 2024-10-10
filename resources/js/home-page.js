let onlineUsers = [];
const username = document.getElementById("current-username").innerText;

Echo.join("chat")
    .here(handleHereUsers)
    .joining(handleUserJoining)
    .leaving(handleUserLeaving)
    .listenForWhisper("memberTyping", handleMemberTyping)
    .listenForWhisper("changeLastMessage", handleChangeLastMessage);

Echo.join(`chat.member.${username}`)
    .listen("CreateNewChat", handleCreateNewChat);

function handleCreateNewChat(e) {
    let event = new Event('update-chat-list');

    window.dispatchEvent(event);
}

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

function handleChangeLastMessage(e) {
    let lastMessageEl = document.getElementById(`last-message-chat-${e.chat_uuid}`);
    let isOwnerEl = document.getElementById(`is-owner-of-last-message-${e.chat_uuid}`);

    if (lastMessageEl) {
        lastMessageEl.innerHTML = e.message;
        if (isOwnerEl) {
            isOwnerEl.classList.add("hidden");
        }
    }
}

function changeUserStatus(username, status = "", elStatus, push = true) {
    let memberStatus = document.getElementById(`member-status-${username}`)
    let memberAvatarStatus = document.getElementById(`avatar-member-status-${username}`)

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
            if (memberAvatarStatus) {
                memberAvatarStatus.classList.remove("hidden");
            }
            firstElementChild.classList.remove("hidden");
        } else if (elStatus === "hidde") {
            if (memberAvatarStatus) {
                memberAvatarStatus.classList.add("hidden");
            }
            firstElementChild.classList.add("hidden");
        }
    }
}

document.addEventListener('livewire:navigated', (event) => {
    onlineUsers.forEach(function (username) {
        changeUserStatus(username, "آنلاین", "show", false);
    });
});
