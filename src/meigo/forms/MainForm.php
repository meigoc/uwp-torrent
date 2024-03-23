<?php
namespace meigo\forms;

use php\torrent\TorrentProcessor;
use php\torrent\TorrentFile;
use php\torrent\DownloadManager;
use gui\Ext4JphpWindows;
use std, gui, framework, meigo;


class MainForm extends AbstractForm
{

    /**
     * @event show 
     */
    function doShow(UXWindowEvent $e = null)
    {    
        $pppp = new Ext4JphpWindows;
        $pppp->addBlur($this);
        $pppp->addBorder($this,1,"#1684de");
        
        $mainMenu = new UXMenuBar(); 

        $mainMenu ->width = 500;

        $mainMenu->opacity = 0.7;
        $mainMenu->y = 29;
   
        $this->add($mainMenu);
        
        
        $Menu = new UXMenu('Файл');
        $vid = new UXMenu('Вид');
        $ser = new UXMenu('Сервис');
        $spr = new UXMenu('Справка');
        
               
        $mainMenu->menus->add($Menu);
        $mainMenu->menus->add($vid);
        $mainMenu->menus->add($ser); 
        $mainMenu->menus->add($spr); 
        $mainMenu->anchors = ['left' => 0, 'right' => 0];
        

        $open = new UXImageView();
      
        $open->image = new UXImage('res://.data/img/icons/plus16.png');    
         
            
        $aff = new UXMenuItem('Добавить торрент-файл...', $open);
        
        $aff->on('action', function ($e) use ($aff){
       
           $ag = $this->fileChooser->execute();
           
           $file = TorrentFile::of($ag);
           $name = fs::name($ag);
           $this->table->items->add(['name' => $name,'size' => "N/AБайт",'status' => "Загрузка",'seeds' => "0 (0)",'peers' => "0 (0)"]); 
           
           $this->textArea->text .= "CreatedBy: ".$file->createdBy."\n";
           $this->textArea->text .= "CreationDate: ".$file->creationDate."\n";
           $this->textArea->text .= "Encoding: ".$file->encoding."\n";
           $this->textArea->text .= "SaveAs: ".$file->saveAs."\n";
           $this->textArea->text .= "Comment: ".$file->comment."\n";
           $this->textArea->text .= "AnnouceUrl: ".$file->announceURL."\n";
           
           $dm = new DownloadManager(TorrentFile::of($ag));
           $dm->startDownload(function () {
               // callback running every 1 second if download doesn't complete
               // callback running not in graphical stream!
               if ($dm->isComplete() == true){
                   alert("Торрент-файл успешно скачан!");
               } else {
                   echo "[INFO] Качается... \n";
               }
            });
           
          
        });                 
      
        $Menu->items->add($aff); 
               

 
        $ext = new UXImageView();
      
        $ext->image = new UXImage('res://.data/img/icons/exit16.png');    
           
                
        $menuItem3 = new UXMenuItem('Выход', $ext); 
        
        $menuItem3->on('action', function ($e) use ($menuItem3){
       
           UXDialog::show('Выбран пункт '.$menuItem3->text);
          
        });                         
      
        $Menu->items->add($menuItem3);
        
        
        
        $create = new UXImageView();
      
        $create->image = new UXImage('res://.data/img/icons/bundleMake32.png');    
           
                
        $menuItem4 = new UXMenuItem('Создать торрент', $create); 
        
        $menuItem4->on('action', function ($e) use ($menuItem4){
       
       $o = $this->dirChooser->execute();
       $p = $this->fileChooserAlt->execute();
       
           $tp = TorrentProcessor();
        $tp->setCreationDate(1710622499);
        $tp->setCreator("jphp torrent api");
        $tp->setEncoding("UTF-8");
$tp->setComment("test");
$tp->setPieceLength(100);
$tp->setAnnounceURL(null); // Often, you can leave empty, because the tracker itself overwrites this header.
$tp->setName("test"); // In what folder will be the data downloaded through our torrent file
$tp->addFile($p);
$tp->save("./test.torrent");
          
        });                         
      
        $ser->items->add($menuItem4);
    }




    /**
     * @event image7.click-Left 
     */
    function doImage7ClickLeft(UXMouseEvent $e = null)
    {    
        echo $this->y."\n";
        echo $this->x."\n";
        if ($this->height < 700){
            $this->maximize();
        } else {
            $this->width = 736;
            $this->height = 472;
            $this->centerOnScreen();
        }
    }

    /**
     * @event image6.click-Left 
     */
    function doImage6ClickLeft(UXMouseEvent $e = null)
    {    
        if ($this->iconified == true){
            $this->iconified = false;
        } else {
            $this->iconified = true;
        }
    }

    /**
     * @event image8.click-Left 
     */
    function doImage8ClickLeft(UXMouseEvent $e = null)
    {    
        app()->shutdown();
    }



}
