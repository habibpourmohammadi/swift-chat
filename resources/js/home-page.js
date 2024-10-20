let onlineUsers = [];
const username = document.getElementById("current-username").innerText;

Echo.join("chat")
    .here(handleHereUsers)
    .joining(handleUserJoining)
    .leaving(handleUserLeaving)
    .listenForWhisper("memberTyping", handleMemberTyping)
    .listenForWhisper("changeLastMessage", handleChangeLastMessage)
    .listen("UpdateProfile", handelUpdateProfile);

Echo.join(`chat.member.${username}`)
    .listen("CreateNewChat", handleCreateNewChat)
    .listen("DeleteMessage", handleDeleteMessage)
    .listenForWhisper("updateOnlineStatus", handleUpdateOnlineStatus);

function handelUpdateProfile(e) {
    let newUsername = e.information.username;
    let oldUsername = e.information.old_username;
    let full_name = e.information.full_name;
    let avatar = e.information.avatar;

    let memberSectionFullNameEl = document.getElementById(`user-full-name-${newUsername}`);
    let memberSectionAvatarEl = document.getElementById(`user-avatar-${newUsername}`);
    let memberSectionMemberStatusEl = document.getElementById(`member-status-${newUsername}`);
    let chatSectionHeaderAvatarEl = document.getElementById(`chat-page-header-avatar-${newUsername}`);
    let chatSectionMemberStatusEl = document.getElementById(`avatar-member-status-${newUsername}`);
    let chatSectionHeaderFullNameEl = document.getElementById(`chat-page-header-full-name-${newUsername}`);
    let chatSectionAvatarEl = document.getElementsByClassName(`chat-page-avatar-${newUsername}`);
    let chatSectionFullNameEl = document.getElementsByClassName(`chat-page-full-name-${newUsername}`);

    if (oldUsername != false) {
        memberSectionFullNameEl = document.getElementById(`user-full-name-${oldUsername}`);
        memberSectionAvatarEl = document.getElementById(`user-avatar-${oldUsername}`);
        memberSectionMemberStatusEl = document.getElementById(`member-status-${oldUsername}`);
        chatSectionHeaderAvatarEl = document.getElementById(`chat-page-header-avatar-${oldUsername}`);
        chatSectionMemberStatusEl = document.getElementById(`avatar-member-status-${oldUsername}`);
        chatSectionHeaderFullNameEl = document.getElementById(`chat-page-header-full-name-${oldUsername}`);
        chatSectionAvatarEl = document.getElementsByClassName(`chat-page-avatar-${oldUsername}`);
        chatSectionFullNameEl = document.getElementsByClassName(`chat-page-full-name-${oldUsername}`);

        if (onlineUsers.includes(oldUsername)) {
            let index = onlineUsers.indexOf(oldUsername);

            if (index !== -1) {
                onlineUsers.splice(index, 1);
                onlineUsers.push(newUsername);

                memberSectionFullNameEl.id = "user-full-name-" + newUsername;
                memberSectionAvatarEl.id = "user-avatar-" + newUsername;
                memberSectionMemberStatusEl.id = "member-status-" + newUsername;
                chatSectionHeaderAvatarEl.id = "chat-page-header-avatar-" + newUsername;
                chatSectionMemberStatusEl.id = "avatar-member-status-" + newUsername;
                chatSectionHeaderFullNameEl.id = "chat-page-header-full-name-" + newUsername;

                if(chatSectionAvatarEl.length > 0){
                    Array.from(chatSectionAvatarEl).forEach((element) => {
                        element.classList.replace(`chat-page-avatar-${oldUsername}`,`chat-page-avatar-${newUsername}`);
                    });

                    chatSectionAvatarEl = document.getElementsByClassName(`chat-page-avatar-${newUsername}`);
                }

                if(chatSectionFullNameEl.length > 0){
                    Array.from(chatSectionFullNameEl).forEach((element) => {
                        element.classList.replace(`chat-page-full-name-${oldUsername}`,`chat-page-full-name-${newUsername}`);
                    });

                    chatSectionFullNameEl = document.getElementsByClassName(`chat-page-full-name-${newUsername}`);
                }
            }
        }
    }


    if (memberSectionFullNameEl) {
        memberSectionFullNameEl.innerText = full_name;
    }

    if (memberSectionAvatarEl) {
        memberSectionAvatarEl.src = avatar;
    }

    if (chatSectionHeaderAvatarEl) {
        chatSectionHeaderAvatarEl.src = avatar;
    }

    if (chatSectionHeaderFullNameEl) {
        chatSectionHeaderFullNameEl.innerText = full_name;
    }

    if(chatSectionAvatarEl.length > 0){
        Array.from(chatSectionAvatarEl).forEach((element) => {
            element.src = avatar;
        });
    }

    if(chatSectionFullNameEl.length > 0){
        Array.from(chatSectionFullNameEl).forEach((element) => {
            element.innerText = full_name;
        });
    }
}

function handleCreateNewChat(e) {
    let event = new Event('update-chat-list');

    window.dispatchEvent(event);

    if (e.newMemberUsername) {
        setTimeout(() => {
            changeUserStatus(e.newMemberUsername, "آنلاین", "show");

            Echo.join(`chat.member.${e.newMemberUsername}`)
                .whisper("updateOnlineStatus", {
                    username: username
                });
        }, 500);
    }
}

function handleDeleteMessage(e) {
    let event = new Event('update-chat-list');
    window.dispatchEvent(event);

    let response = {};

    if (e.isLastMessage == false) {
        response = {
            chat_uuid: e.chatUuid,
            message: "پیامی ثبت نشده !",
            chat_status: "clear"
        }
    } else {
        response = {
            chat_uuid: e.chatUuid,
            message: truncateString(e.isLastMessage.message, 20),
            lastMessageUsername: e.isLastMessage.username,
        }
    }

    setTimeout(() => {
        handleChangeLastMessage(response);
    }, 200);
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
        lastMessageEl.classList.remove("text-red-400");
        lastMessageEl.classList.remove("font-bold");
        if (isOwnerEl && e.lastMessageUsername == null) {
            isOwnerEl.classList.add("hidden");
            if (e.chat_status && e.chat_status == "clear") {
                document.getElementById(`last-message-wrapper-${e.chat_uuid}`).innerHTML = renderClearChatMessage(e.message, e.chat_uuid);
            }
        } else if (e.lastMessageUsername || e.chat_status) {
            let lastMessageWrapper = document.getElementById(`last-message-wrapper-${e.chat_uuid}`);
            let lastMessageChat = document.getElementById(`last-message-chat-${e.chat_uuid}`);

            if (e.chat_status && e.chat_status == "clear") {
                lastMessageWrapper.innerHTML = renderClearChatMessage(e.message, e.chat_uuid);
                return;
            }

            if (e.lastMessageUsername == username) {
                if (!isOwnerEl) {
                    lastMessageWrapper.innerHTML = renderMyLastMessage(e.message, e.chat_uuid);
                } else {
                    lastMessageChat.innerHTML = e.message;
                    isOwnerEl.classList.remove("hidden");
                }
            } else {
                if (isOwnerEl) {
                    lastMessageChat.innerHTML = e.message;
                    isOwnerEl.classList.add("hidden");
                } else {
                    lastMessageChat.innerHTML = e.message;
                }
            }
        }
    }
}

function renderClearChatMessage(message, chatUuid) {
    return `
        <span id="last-message-chat-${chatUuid}" class="text-red-400 font-bold">
          ${message}
        </span>
    `;
}

function renderMyLastMessage(message, chatUuid) {
    return `
            <span id="is-owner-of-last-message-${chatUuid}" class="text-blue-500">
              شما :
            </span>
            <span id="last-message-chat-${chatUuid}">
              ${message}
            </span>
        `;
}

function handleUpdateOnlineStatus(e) {
    changeUserStatus(e.username, "آنلاین", "show");
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

function truncateString(str, num) {
    if (str.length <= num) {
        return str;
    }
    return str.slice(0, num) + "...";
}

document.addEventListener('livewire:navigated', (event) => {
    onlineUsers.forEach(function (username) {
        changeUserStatus(username, "آنلاین", "show", false);
    });
});
