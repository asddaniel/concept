import { spawn, exec } from "child_process"
import { watch } from "fs/promises"

const [node, _, file] = process.argv
const procede = spawn(node, [file])
procede.stdout.pipe(process.stdout)
procede.stdin.pipe(process.stdout)
procede.on('data', (data)=>{
    console.log(data)
})

