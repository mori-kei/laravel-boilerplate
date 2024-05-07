const { execSync } = require('child_process')
const { join } = require('path')
const { readdirSync, lstatSync } = require('fs')

const DIRECTORY = '.'
let ERRORS_FOUND = false

const isPhpFile = (file) => file.endsWith('.php') && !file.endsWith('.blade.php')

const checkPhpFile = (file) => {
  const command = `php -l "${file}"`
  try {
    execSync(command)
  } catch (error) {
    console.log(error.stdout.toString().trim())
    ERRORS_FOUND = true
  }
}

const checkDirectory = (dir) => {
  readdirSync(dir).forEach((file) => {
    const fullPath = join(dir, file)
    if (lstatSync(fullPath).isDirectory()) {
      if (!fullPath.includes('vendor') && !fullPath.includes('frontend') && !fullPath.includes('storage')) {
        checkDirectory(fullPath)
      }
    } else if (isPhpFile(file)) {
      checkPhpFile(fullPath)
    }
  })
}

checkDirectory(DIRECTORY)

if (ERRORS_FOUND) {
  process.exit(1)
}
