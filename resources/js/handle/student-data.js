
function additionalHandler(student){
    try{
        handlerStudentData(student);
    }catch(error){
        return;
    }
}

function handleStudentData(){
    document.getElementById('student_nis').addEventListener('change', (e) => {
        const student = students.find(s => s.nis == e.target.value);
        if(!student) return;
        additionalHandler(student);
    });
}

handleStudentData();