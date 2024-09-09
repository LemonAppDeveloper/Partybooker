var editor = new Quill("#editor", {
  styles: {
    ".ql-container": {
      "padding": "5px 0",
      "min-height": "120px"
    },
    ".ql-editor": {
      "font-family": "Arial, sans-serif",
      "font-size": "16px",
      "line-height": "1.5em"
    }
  },
  formats: ["bold", "italic", "underline", "strike", "list", "bullet", "align"]
});
editor.addModule("toolbar", { container: "#toolbar" });
editor.on("text-change", function() {
  $("#content").val(editor.getHTML());
});
var delayit;
$("#editor .ql-editor").focus(function() {
  $("#editorwrap").addClass("focus");
  clearTimeout(delayit);
}).blur(function() {
  if ($("#editorwrap").is(":hover")) {
    delayit = setTimeout(function() {
      $("#editorwrap").removeClass("focus");
    }, 200);
  } else {
    $("#editorwrap").removeClass("focus");
  }
});
$("#toolbar button").click(function(e) {
  e.preventDefault();
});
$("form").submit(function() {
  $("#content").val(editor.getHTML());
});