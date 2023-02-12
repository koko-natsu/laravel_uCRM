const nl2br = (str) => {
  if(str) {
    var res = str.replace(/\r\n/g, "<br>");
    res = res.replace(/(\n|\r)/g, "<br>");
    return res;
  } else {
    return "&nbsp";
  }
}

export { nl2br }