const defaultHandler = () => {};
const handler = handlerStudentData ?? defaultHandler;
function handleStudentData(){
    document.getElementById('student_nis').addEventListener('change', (e) => {
        const student = students.find(s => s.nis == e.target.value);
        if(!student) return;
        handler(student);
    });
}

handleStudentData();