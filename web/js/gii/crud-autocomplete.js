$(document).ready(function () {

    var templateDestinationSelect = $("select[name='Generator[templateDestination]']");
    var modelClassInput = $("input[name='Generator[modelClass]']");
    var searchModelClassInput = $("input[name='Generator[searchModelClass]']");
    var controllerClassInput = $("input[name='Generator[controllerClass]']");
    var viewPathInput = $("input[name='Generator[viewPath]']");

    modelClassInput.change(function () {
        var destination = templateDestinationSelect.val();
        var modelClass = $(this).val();
        var modelNs = modelClass.substr(0, modelClass.lastIndexOf("\\"));
        var targetNs = destination + modelNs.substr(modelNs.indexOf("\\"));
        var modelClassName = modelClass.substr(modelClass.lastIndexOf("\\") + 1);
        var modelViewName = modelClassName.replace(/([a-z])([A-Z])/g, '$1-$2').toLowerCase();

        var modelSearchClass = modelNs + "\\search\\" + modelClassName + "Search";
        searchModelClassInput.val(modelSearchClass);

        var controllerClassName = targetNs.replace("models", "controllers") + "\\" + modelClassName + "Controller";
        controllerClassInput.val(controllerClassName);

        var viewPath = "@app/../" + destination + "/views/" + modelViewName;
        viewPathInput.val(viewPath);
    })

});