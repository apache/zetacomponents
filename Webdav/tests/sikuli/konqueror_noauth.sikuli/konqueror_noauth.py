# coding=utf-8
setThrowException(True)

class Konqueror:

   REMOTE = 0
   LOCAL = 1

   _tab = None

   _dirs = {}

   def __init__(self):
      self._dirs = {self.LOCAL: [], self.REMOTE: []}
      self._startKonqueror()
      self._initWebdav()
      sleep(2)
      self._initLocal()
      sleep(2)

   def _startKonqueror(self):
      # this script starts "konqueror &"
      openApp("/home/dotxp/bin/start_konqueror.sh")
      sleep(1)
      wait(Pattern("1266401481278.png").similar(0.80).firstN(1))

   def _initWebdav(self):
      type("l", KEY_CTRL)
      paste("webdav://webdav")
      type(Key.ENTER)
      self._tab = self.REMOTE
      self._dirs[self.REMOTE].append("/")

   def _initLocal(self):
      type("t", KEY_CTRL)
      sleep(1)
      self._tab = self.LOCAL
      type("l", KEY_CTRL)
      paste("/home/dotxp/Desktop/Temp/put_test/down")
      type(Key.ENTER)
      self._dirs[self.LOCAL].append("/")
      self._dirs[self.LOCAL].append("down")

   def switchRemote(self):
      if (self._tab == self.LOCAL):
         type(",", KEY_CTRL)
         self._tab = self.REMOTE
         sleep(0.4)

   def switchLocal(self):
      if (self._tab == self.REMOTE):
         type(",", KEY_CTRL)
         self._tab = self.LOCAL
         sleep(0.4)

   def openLocal(self, dirImg, dirName):
      self.switchLocal()
      self._open(dirImg, dirName)

   def _open(self, dirImg, dirName):
      doubleClick(dirImg)
      self._dirs[self._tab].append(dirName)

   def openRemote(self, dirImg, dirName):
      self.switchRemote()
      self._open(dirImg, dirName)

   def upRemote(self, dirName=None):
      self.switchRemote()
      sleep(1)
      self.goUp(dirName)

   def upLocal(self, dirName=None):
      self.switchLocal()
      sleep(1)
      self.goUp(dirName)

   def goUp(self, dirName):
      if dirName == None:
         click(Pattern("1266259183958.png").similar(0.60).firstN(1))
         self._dirs[self._tab].pop()
         return
      while self._dirs[self._tab][-1] != dirName:
         click(Pattern("1266259183958.png").similar(0.60).firstN(1))
         self._dirs[self._tab].pop()

   def copy(self):
      type("c", KEY_CTRL)

   def paste(self):
      type("v", KEY_CTRL)

   def rename(self, fileImg, newName, newFileImg):
      click(fileImg)
      sleep(0.2)
      type(Key.F2)
      wait(Pattern("1266428301207.png").similar(0.50).firstN(1))
      
      type("a", KEY_CTRL)
      sleep(0.2)
      paste(newName)
      sleep(0.1)
      type(Key.ENTER)
      wait(newFileImg)

   def createDir(self, dirName, dirImg):
      type(Key.F10)
      createDirDiag = wait(Pattern("1266404189832.png").similar(0.80).firstN(1))
      if len(createDirDiag) == 0:
         raise SystemExit("Could not find new dir dialog")
      paste(dirName)
      type(Key.ENTER)
      sleep(1)
      find(dirImg)


class KonquerorWebdavTest:

   _client = None

   def __init__(self, client):
      self._client = client

   def run(self):
      self.testInitial()
      self.testListCollection()
      self.testDownloadSingle()
      self.testListSubdir()
      self.testDownloadMultiple()
      self.testCreateNewdir()
      self.testListNewdir()
      self.testUploadSingle()
      self.testCreateNewsubdir()
      self.testListNewsubdir()
      self.testUploadSingleOverwrite()
      self.testDeleteNewdir()
      self.testUploadNew()
      self.testDownloadUploaded()
      self.testRenameFiles()
      self.testCopyFilesRemote()
      self.testRenameCollection()
      self.testCopyCollectionSame()
      pass

   def testInitial(self):
      self._client.switchRemote()
      find(Pattern("1266403774620.png").similar(0.80).firstN(1))

   def testListCollection(self):
      self._client.openRemote(Pattern("1266403317481.png").similar(0.80).firstN(1), "collection")
      find(Pattern("1266403396957.png").similar(0.80).firstN(1))

   def testDownloadSingle(self):
      self._client.switchRemote()
      click(Pattern("1266403844742.png").similar(0.80).firstN(1))
      self._client.copy()
      self._client.switchLocal()
      sleep(1)
      self._client.paste()
      sleep(1)
      find(Pattern("1266403586626.png").similar(0.80).firstN(1))

   def testListSubdir(self):
      self._client.openRemote(Pattern("1266403618714.png").similar(0.80).firstN(1), "subdir")
      find(Pattern("1266424593041.png").similar(0.80).firstN(1))

   def testDownloadMultiple(self):
      self._client.switchRemote()
      click(Pattern("1266403938988.png").similar(0.80).firstN(1))
      type(Key.RIGHT, KEY_SHIFT)
      self._client.copy()
      sleep(1)
      self._client.switchLocal()
      sleep(1)
      self._client.paste()
      sleep(1)
      find(Pattern("1266403982273.png").similar(0.80).firstN(1))

   def testCreateNewdir(self):
      self._client.switchRemote()
      self._client.createDir("newdir", Pattern("1266404324764.png").similar(0.79).firstN(1))

   def testListNewdir(self):
      self._client.openRemote(Pattern("1266404324764.png").similar(0.79).firstN(1), "newdir")
      find(Pattern("1266404387459.png").similar(0.80).firstN(1))

   def testUploadSingle(self):
      self._client.switchLocal()
      click(Pattern("1266405005919.png").similar(0.80).firstN(1))
      self._client.copy()
      self._client.switchRemote()
      self._client.paste()
      find(Pattern("1266404478750.png").similar(0.80).firstN(1))

   def testCreateNewsubdir(self):
      self._client.switchRemote()
      self._client.createDir("newsubdir", Pattern("1266404642076.png").similar(0.80).firstN(1))

   def testListNewsubdir(self):
      self._client.openRemote(Pattern("1266424853166.png").similar(0.80).firstN(1), "newsubdir")
      find(Pattern("1266424893903.png").similar(0.80).firstN(1))

   def testUploadSingleOverwrite(self):
      self._client.switchLocal()
      click(Pattern("1266405005919.png").similar(0.80).firstN(1))
      self._client.copy()
      self._client.switchRemote()
      self._client.paste()
      find(Pattern("1266404478750.png").similar(0.80).firstN(1))
      self._client.switchLocal()
      click(Pattern("1266405005919.png").similar(0.80).firstN(1))
      self._client.copy()
      self._client.switchRemote()
      self._client.paste()
      wait(Pattern("1266427667434.png").similar(0.30).firstN(1))
      click(Pattern("1266425303012.png").similar(0.70).firstN(1))
      find(Pattern("1266404478750.png").similar(0.80).firstN(1))

   def testDeleteNewdir(self):
      self._client.upRemote("collection")
      click(Pattern("1266425401724.png").similar(0.80).firstN(1))
      type(Key.DELETE)
      wait(Pattern("1266425429809.png").similar(0.70).firstN(1))
      click(Pattern("1266425459006.png").similar(0.70).firstN(1))
      find(Pattern("1266425612217.png").similar(0.80).firstN(1))

   def testUploadNew(self):
      self._client.upLocal("/")
      self._client.openLocal(Pattern("1266425647634.png").similar(0.90).firstN(1), "up")
      type("a", KEY_CTRL)
      sleep(0.5)
      self._client.copy()
      self._client.switchRemote()
      sleep(1)
      self._client.paste()
      sleep(2)
      find(Pattern("1266425732567.png").similar(0.80).firstN(1))

   def testDownloadUploaded(self):
      self._client.switchRemote()
      # delete first, to copy everything else
      click(Pattern("1266403844742.png").similar(0.80).firstN(1))
      type(Key.DELETE)
      sleep(0.5)
      type(Key.ENTER)
      sleep(1)
      type("a", KEY_CTRL)
      sleep(1)
      self._client.copy()
      self._client.upLocal("/")
      self._client.openLocal(Pattern("1266425995532.png").similar(0.80).firstN(1), "down")
      self._client.paste()
      find(Pattern("1266426251752.png").similar(0.80).firstN(1))

   def testRenameFiles(self):
      self._client.switchRemote()
      self._client.rename(Pattern("1266426292140.png").similar(0.80).firstN(1), u"put_test_renamed.xml", Pattern("1266426519794.png").similar(0.80).firstN(1))
      sleep(0.5)
      self._client.rename(Pattern("1266426596595.png").similar(0.80).firstN(1), u"put_test_utf8_\u00f6\u00e4\u00fc\u00df.txt", Pattern("1266426643952.png").similar(0.80).firstN(1))
      sleep(0.5)
      self._client.rename(Pattern("1266429314226.png").similar(0.70).firstN(1), u"put_non_utf8_test.txt", Pattern("1266426731983.png").similar(0.80).firstN(1))

   def testCopyFilesRemote(self):
      self._client.switchRemote()
      click(Pattern("1266427115069.png").similar(0.80).firstN(1))
      type(Key.RIGHT, KEY_SHIFT)
      sleep(1)
      type(Key.RIGHT, KEY_SHIFT)
      sleep(1)
      self._client.copy()
      self._client.openRemote(Pattern("1266427167957.png").similar(0.80).firstN(1), "collection")
      sleep(1)
      self._client.paste()
      wait(Pattern("1266429510001.png").similar(0.70).firstN(1))

   def testRenameCollection(self):
      self._client.upRemote()
      self._client.rename(Pattern("1266427306959.png").similar(0.80).firstN(1), "renamed_collection", Pattern("1266427339100.png").similar(0.80).firstN(1))

   def testCopyCollectionSame(self):
      click(Pattern("1266427428035.png").similar(0.80).firstN(1))
      self._client.copy()
      sleep(1)
      self._client.paste()
      wait(Pattern("1266427467448.png").similar(0.80).firstN(1))
      type(Key.ENTER)

konqueror = Konqueror()
test = KonquerorWebdavTest(konqueror)
test.run()
