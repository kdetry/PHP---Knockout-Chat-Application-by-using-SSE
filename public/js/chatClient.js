/* 
 Created on : 26.Ağu.2017, 00:31:07
 Author     : Mustafa Tunçau
 */


/**
 * Chat Object for pass Data
 * @param {Object} data
 * @returns {Chat}
 */
var Chat = function (data) {
    this.senderId = data.senderId;
    this.messageText = data.messageText;
};


var Avatar = function (data) {
    this.id = data.id;
    this.image = './img/avatars/' + data.image;
};

var Account = function (data) {
    this.name = data.name;
    this.avatarId = data.avatarId;
};

/**
 * KnockOut View Model
 * @returns {chatListViewModel}
 */

var chatListViewModel = function () {
    var self = this;
    self.chats = ko.observableArray([]);
    self.activeUsers = ko.observableArray([]);

    self.sse = new EventSource('./getChatList');
    self.sse.addEventListener('message', function (e) {
        var jsonData = JSON.parse(e.data);
        self.chats.removeAll();
        for (i = 0; i < jsonData.length; i++) {
            self.chats.push(jsonData[i]);
        }
    }, false);

    self.sseUserList = new EventSource('./getActiveUserList');
    self.sseUserList.addEventListener('userlist', function (e) {
        var jsonData = JSON.parse(e.data);
        self.activeUsers.removeAll();
        for (i = 0; i < jsonData.length; i++) {
            self.activeUsers.push(jsonData[i]);
        }
    }, false);

    this.getAvatarList();
};

chatListViewModel.prototype.windowHeight = function() {
    return $(window).height()-140;
};

/**
 * Sets new Chat Line
 * @type ko.observable.observable
 */
chatListViewModel.prototype.newChatLine = ko.observable();


/**
 * Create a new Instance of CookieHelper
 * @type Arguments
 */
chatListViewModel.prototype.cookieHelper = new cookieHelper;

/**
 * Read AvatarId from Cookie
 * @type ko.observable.observable
 */
chatListViewModel.prototype.avatarId = ko.observable(chatListViewModel.prototype.cookieHelper.getProperty('avatarId'));

/**
 * Read Sender from Cookie
 * @type ko.observable.observable
 */
chatListViewModel.prototype.sender = ko.observable(chatListViewModel.prototype.cookieHelper.getProperty('sender'));

/**
 * Set SenderId
 * @type integer
 */
chatListViewModel.prototype.senderId = ko.observable(chatListViewModel.prototype.cookieHelper.getProperty('senderId'));

chatListViewModel.prototype.hasSenderId = ko.computed(function () {
    if (this.senderId() !== null) {
        return true;
    }
    return false;
}, chatListViewModel.prototype);

/**
 * addChat by Ajax
 * @returns void
 */
chatListViewModel.prototype.addChat = function () {
    $.ajax("./messageSend", {
        data: ko.toJSON(new Chat({senderId: this.senderId(), messageText: this.newChatLine()})),
        type: "post",
        contentType: "application/json",
        success: function (result) {
            console.log(result);
            console.log("Message has been sent");
            chatListViewModel.prototype.newChatLine('');
        },
        error: function (data) {
            alert('error');
        }
    });
};


/**
 * check username and avatar for modal
 * @returns {Boolean}
 */

chatListViewModel.prototype.isShowModal = function () {
    if (this.senderId() === null || this.sender() === null || this.avatarId() === null) {
        return true;
    }
    return false;
};

/**
 * Set observable showdialog bindingValue. It uses ko.bindingHandlers.modal in view
 * @type ko.observable.observable
 */
chatListViewModel.prototype.showDialog = ko.observable(chatListViewModel.prototype.isShowModal());



/**
 * check username and avatar for modal
 * @returns void
 */

chatListViewModel.prototype.setSenderAndAvatar = function () {
    if (this.sender().trim().length === 0) {
        alert("You Should Enter Username");
    }
    this.cookieHelper.setProperty('sender', this.sender());
    this.cookieHelper.setProperty('avatarId', this.avatarId());
    $.ajax("./saveUser", {
        data: ko.toJSON(new Account({name: this.sender(), avatarId: this.avatarId()})),
        type: "post",
        contentType: "application/json",
        success: function (result) {
            if (typeof result.status !== 'undefined' && isNaN(result.status) === false) {
                chatListViewModel.prototype.cookieHelper.setProperty('senderId', result.status);
                chatListViewModel.prototype.senderId(result.status);
            }
        }
    });
};


/**
 * AvatarList for Binding
 * @type ko.observableArray.result
 */
chatListViewModel.prototype.avatars = ko.observableArray([]);

/**
 * Fill up AvatarList
 * @returns void
 */
chatListViewModel.prototype.getAvatarList = function () {
    $.getJSON("./getAvatarList", function (allData) {
        var avatarList = $.map(allData, function (item) {
            return new Avatar(item);
        });
        chatListViewModel.prototype.avatars(avatarList);
    });
};

/**
 * Checks Radio Box Of Image
 * @param {Avatar} avatar
 * @returns {undefined}
 */
chatListViewModel.prototype.checkRadioBox = function (avatar) {
    chatListViewModel.prototype.avatarId(avatar.id);
};

/**
 * This method for check "is Message will be show on left or right"
 * @param {type} item
 * @returns {Boolean}
 */
chatListViewModel.prototype.leftRightCheck = function (item){
    if(item === chatListViewModel.prototype.senderId()){
        return true;
    }
    return false;
};

ko.applyBindings(new chatListViewModel());