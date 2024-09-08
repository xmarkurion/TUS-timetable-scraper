import fs from 'fs';
import path from 'path';

export class FileProcessor{
    
    public async saveToFile(destinationFolder, fileName, content){
        await this.makeFolders(destinationFolder);
        fs.writeFile(path.join(destinationFolder, fileName), content, (err) => {
            if (err) throw err;
        });
    }

    public async makeFolders(destinationPath: string){
        try {
            fs.mkdirSync(destinationPath, { recursive: true } );
        } catch (e) {
            console.log('Cannot create folder ', e);
        }
    }

    public async exist(destinationPathOrFile: string): Promise<boolean>{
        return fs.existsSync(destinationPathOrFile)
    }

    public async parse(jsonFile:string){
       try{
        return JSON.parse(fs.readFileSync(jsonFile, 'utf-8'));
       }catch(error) {
        return null;
       }
    }

    public fix(data: string){
        //
    }
}