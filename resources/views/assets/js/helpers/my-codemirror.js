export async function myCodeMirror(selector, height = 105) {
    const {
        default: CodeMirror
    } = await import('codemirror');

    await Promise.all([
        import('codemirror/mode/javascript/javascript'),
        import('codemirror/addon/selection/active-line'),
        import('codemirror/addon/edit/matchbrackets'),
        import('codemirror/addon/scroll/simplescrollbars'),
        import('codemirror/theme/material-darker.css'),
        import('codemirror/addon/scroll/simplescrollbars.css'),
    ]);

    const editor = CodeMirror.fromTextArea(document.getElementById(selector), {
        mode: "javascript",
        theme: "material-darker",
        lineNumbers: true,
        styleActiveLine: true,
        matchBrackets: true,
        scrollbarStyle: "simple"
    });

    editor.setSize(null, height);
    return editor;
}
