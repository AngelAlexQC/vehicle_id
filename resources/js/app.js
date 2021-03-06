require("./bootstrap");

const id = parseInt($("#user_id").val());
window.Echo.channel("my-channel").listen("RecordSaved", (e) => {
    if (id == e.record.user_id) {
        window.location.reload();
    }
});
