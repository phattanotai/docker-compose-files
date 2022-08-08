var datas = [
    { id: 1, parent: 0 },
    //1
    { id: 2, parent: 1 },
    { id: 3, parent: 1 },
    //2
    { id: 4, parent: 2 },
    { id: 5, parent: 2 },
    { id: 6, parent: 3 },
    { id: 7, parent: 3 },
    //3
    { id: 8, parent: 4 },
    { id: 9, parent: 4 },
    { id: 10, parent: 5 },
    { id: 11, parent: 5 },
    { id: 12, parent: 6 },
    { id: 13, parent: 6 },
    { id: 14, parent: 7 },
    { id: 15, parent: 7 },
    ////4
    { id: 16, parent: 8 },
    { id: 17, parent: 8 },
    { id: 18, parent: 9 },
    { id: 19, parent: 9 },
    { id: 20, parent: 10 },
    { id: 21, parent: 10 },
    { id: 22, parent: 11 },
    { id: 23, parent: 11 },
    { id: 24, parent: 13 },
    { id: 25, parent: 14 },
    { id: 26, parent: 14 },
    ////5
    { id: 27, parent: 16 },
    { id: 28, parent: 18 },
    { id: 29, parent: 20 },
    { id: 30, parent: 26 },
    ////6
    { id: 31, parent: 27 },
    { id: 32, parent: 27 },
    { id: 33, parent: 29 },
    { id: 34, parent: 29 },
    { id: 35, parent: 30 },
    { id: 36, parent: 30 },
];
function findMember(level) {
    var parentId = [1];
    var memberId = [];
    for (var i = 0; i <= level; i++) {
        memberId = [];
        datas.find(function (e) {
            if (parentId.includes(e.parent)) {
                memberId.push(e.id);
            }
        });
        if (i < level) {
            parentId = memberId;
        }
    }
    return parentId.length;
}
console.log(findMember(6));
