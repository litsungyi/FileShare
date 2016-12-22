function Mover(objRow) {
  objRow.className = "bg2";
}

function Mout(objRow, i) {
  objRow.className = "bg" + i;
}

function ChgStyle(folder, style) {
  this.location="./file.php?style="  + style + "&folder=" + folder;
}

function FUpload(folder) {
  document.getElementById("FileForm").action = "./upload.php?folder=" + folder;
  document.getElementById("FileForm").submit();
}

function FMkDir(folder) {
  var name;

  name = prompt("Input dir neme.", "");

  if(name==null) {

  } else if (name!="") {
    document.getElementById("FileForm").action = "./newfolder.php?name=" + name + "&folder=" + folder;
    document.getElementById("FileForm").submit();
  } else {
    alert("Folder name could not be null.");
  }
}

function FDownFile(folder, name) {
  if(confirm("Are you sure download the file " + name)) {
    window.open("./downfile.php?folder=" + folder + "&filename=" + name);
  } else {

  }
}

function FDelFile(folder, name) {
  if(confirm("Are you sure delete file " + name)) {
    document.getElementById("FileForm").action = "./delfile.php?name=" + name + "&folder=" + folder;
    document.getElementById("FileForm").submit();
  } else {

  }
}

function FDelFolder(folder, name) {
  if(confirm("Are you sure delete folder " + name)) {
    document.getElementById("FileForm").action = "./delfolder.php?name=" + name + "&folder=" + folder;
    document.getElementById("FileForm").submit();
  } else {

  }
}

function FRename(folder, name) {
  var newname;
                                                                                
  newname = prompt("Input new file neme.", name);
                                                                                
  if(newname==null) {
                                                                                
  } else if (newname!="") {
    document.getElementById("FileForm").action = "./renfile.php?name=" + name + "&newname=" + newname + "&folder=" + folder;
    document.getElementById("FileForm").submit();
  } else {
    alert("New file name could not be null.");
  }
}
