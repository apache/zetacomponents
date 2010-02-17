# coding=utf-8
setThrowException(True)

class Nautilus:

   REMOTE = 0
   LOCAL = 1

   _tab = None

   _dirs = {}

   def __init__(self):
      self._dirs = {self.LOCAL: [], self.REMOTE: []}
      self._startNautilus()
      self._initWebdav()
      sleep(1)
      self._initLocal()

   def _startNautilus(self):
      openApp("/usr/bin/nautilus")
      wait(Pattern("1265282313623.png").similar(0.70).firstN(1))

   def _initWebdav(self):
      click("1265202229746.png")
      click("1265202325039.png")
      click("1265202559414.png")
      click("1265278752490.png")
      type("1265278810480.png", "webdav")
      type(Pattern("1266393612873.png").similar(0.80).firstN(1), "secure_collection")
      type("1266320552496.png", "some")
      click("1265279597052.png")
      setThrowException(False)
      pwField = wait(Pattern("1266321197328.png").similar(0.70).firstN(1), 6000)
      # Nautilus stores password until user logs out
      if len(pwField) != 0:
         type(pwField.inside().find("1266321225325.png"), "thing")
         checkBoxes = find(Pattern("1266321321797.png").similar(0.70).firstN(1))
         click(checkBoxes.inside().find(Pattern("1266321357040.png").similar(0.70).firstN(1)))
         click(Pattern("1266321387258.png").similar(0.70).firstN(1))
      setThrowException(True)
      self._tab = self.REMOTE
      self._dirs[self.REMOTE].append("/")
      self._dirs[self.REMOTE].append("secure_collection")

   def _initLocal(self):
      type("t", KEY_CTRL)
      sleep(1)
      self._tab = self.LOCAL
      click("1265313336023.png")
      self._dirs[self.LOCAL].append("/")
      self.openLocal("1265314310481.png", "down")

   def switchRemote(self):
      if (self._tab == self.LOCAL):
         type(Key.PAGE_UP, KEY_CTRL)
         self._tab = self.REMOTE
         sleep(0.4)

   def switchLocal(self):
      if (self._tab == self.REMOTE):
         type(Key.PAGE_DOWN, KEY_CTRL)
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
         click(Pattern("1266259183958.png").similar(0.90).firstN(1))
         self._dirs[self._tab].pop()
         return
      while self._dirs[self._tab][-1] != dirName:
         click(Pattern("1266259183958.png").similar(0.90).firstN(1))
         self._dirs[self._tab].pop()

   def copy(self):
      type("c", KEY_CTRL)

   def paste(self):
      type("v", KEY_CTRL)

   def rename(self, fileImg, newName, newFileImg):
      click(fileImg)
      sleep(0.2)
      type(Key.F2)
      sleep(0.5)
      type("a", KEY_CTRL)
      sleep(0.2)
      paste(newName)
      sleep(0.1)
      type(Key.ENTER)
      wait(newFileImg)

class NautilusWebdavTest:

   _nautilus = None

   def __init__(self, nautilus):
      self._nautilus = nautilus

   def run(self):
      # secure_collection opened initially
      # self.testInitial()
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

   def testInitial(self):
      self._nautilus.switchRemote()
      find(Pattern("1265793342336.png").similar(0.70).firstN(1))

   def testListCollection(self):
      # secure_collection opened on init
      # self._nautilus.openRemote("1265279909203.png", "collection")
      self._nautilus.switchRemote()
      find(Pattern("1265793562509.png").similar(0.70).firstN(1))

   def testDownloadSingle(self):
      self._nautilus.switchRemote()
      click(Pattern("1265314613379.png").similar(0.95).firstN(1))
      self._nautilus.copy()
      self._nautilus.switchLocal()
      sleep(1)
      self._nautilus.paste()
      sleep(1)
      find(Pattern("1266397437910.png").similar(0.80).firstN(1))

   def testListSubdir(self):
      self._nautilus.openRemote("1265315881723.png", "subdir")
      find("1265315899109.png")

   def testDownloadMultiple(self):
      self._nautilus.switchRemote()
      click(Pattern("1265795508414.png").similar(0.70).firstN(1))
      type(Key.DOWN, KEY_SHIFT)
      self._nautilus.copy()
      sleep(1)
      self._nautilus.switchLocal()
      sleep(1)
      self._nautilus.paste()
      sleep(1)
      find(Pattern("1265822372031.png").similar(0.90).firstN(1))

   def testCreateNewdir(self):
      self._nautilus.switchRemote()
      type("n", KEY_CTRL | KEY_SHIFT)
      sleep(1)
      type("newdir")
      type("\n")
      find(Pattern("1266256110323.png").similar(0.90).firstN(1))

   def testListNewdir(self):
      self._nautilus.openRemote("1266256707500.png", "newdir")
      find(Pattern("1266256773322.png").similar(0.90).firstN(1))

   def testUploadSingle(self):
      self._nautilus.switchLocal()
      click(Pattern("1266256870724.png").similar(0.90).firstN(1))
      self._nautilus.copy()
      self._nautilus.switchRemote()
      self._nautilus.paste()
      find(Pattern("1266256969255.png").similar(0.90).firstN(1))

   def testCreateNewsubdir(self):
      self._nautilus.switchRemote()
      type("n", KEY_CTRL | KEY_SHIFT)
      sleep(1)
      type("newsubdir")
      type("\n")
      find(Pattern("1266257989662.png").similar(0.90).firstN(1))

   def testListNewsubdir(self):
      self._nautilus.openRemote("1266256707500.png", "newdir")
      find(Pattern("1266258293601.png").similar(0.90).firstN(1))

   def testUploadSingleOverwrite(self):
      self._nautilus.switchLocal()
      click(Pattern("1266257097775.png").similar(0.90).firstN(1))
      self._nautilus.copy()
      self._nautilus.switchRemote()
      self._nautilus.paste()
      find(Pattern("1266258371198.png").similar(0.78).firstN(1))
      self._nautilus.switchLocal()
      click(Pattern("1266257097775.png").similar(0.90).firstN(1))
      self._nautilus.copy()
      self._nautilus.switchRemote()
      self._nautilus.paste()
      wait(Pattern("1266397752968.png").similar(0.80).firstN(1))
      dialog = find(Pattern("1266397783288.png").similar(0.80).firstN(1))
      click(dialog.inside().find(Pattern("1266257459272.png").similar(0.90).firstN(1)))
      find(Pattern("1266258834123.png").similar(0.90).firstN(1))

   def testDeleteNewdir(self):
      self._nautilus.upRemote("secure_collection")
      click(Pattern("1266259247619.png").similar(0.90).firstN(1))
      type(Key.DELETE)
      wait(Pattern("1266259486059.png").similar(0.55).firstN(1))
      dialog = find(Pattern("1266259486059.png").similar(0.55).firstN(1))
      click(dialog.inside().find(Pattern("1266259533961.png").similar(0.90).firstN(1)))
      sleep(1)
      find(Pattern("1266398284223.png").similar(0.80).firstN(1))

   def testUploadNew(self):
      self._nautilus.upLocal("/")
      self._nautilus.openLocal(Pattern("1266259890975.png").similar(0.90).firstN(1), "up")
      type("a", KEY_CTRL)
      sleep(0.5)
      self._nautilus.copy()
      self._nautilus.switchRemote()
      sleep(1)
      self._nautilus.paste()
      find(Pattern("1266398512093.png").similar(0.70).firstN(1))
      find(Pattern("1266398764125.png").similar(0.80).firstN(1))

   def testDownloadUploaded(self):
      self._nautilus.switchRemote()
      # downloading dirs is broken in Nautilus
      click(Pattern("1266269427884.png").similar(0.90).firstN(1))
      type(Key.DOWN, KEY_SHIFT)
      type(Key.DOWN, KEY_SHIFT)
      type(Key.DOWN, KEY_SHIFT)
      self._nautilus.copy()
      self._nautilus.upLocal("/")
      self._nautilus.openLocal("1265314310481.png", "down")
      self._nautilus.paste()

   def testRenameFiles(self):
      self._nautilus.switchRemote()
      self._nautilus.rename("1266270237742.png", u"put_test_renamed.xml", Pattern("1266270332525.png").similar(0.90).firstN(1))
      self._nautilus.rename("1266270356862.png", u"put_test_utf8_\u00f6\u00e4\u00fc\u00df.txt", Pattern("1266274332854.png").similar(0.80).firstN(1))
      self._nautilus.rename(Pattern("1266270558156.png").similar(0.90).firstN(1), u"put_non_utf8_test.txt", Pattern("1266270602424.png").similar(0.90).firstN(1))

   def testCopyFilesRemote(self):
      self._nautilus.switchRemote()
      click(Pattern("1266274684143.png").similar(0.80).firstN(1))
      # invert selection
      type("i", KEY_CTRL | KEY_SHIFT)
      sleep(1)
      self._nautilus.copy()
      self._nautilus.openRemote(Pattern("1266274684143.png").similar(0.80).firstN(1), "collection")
      sleep(1)
      self._nautilus.paste()
      wait(Pattern("1266311546228.png").similar(0.70).firstN(1))
      find(Pattern("1266311574320.png").similar(0.70).firstN(1))
      find(Pattern("1266311712385.png").similar(0.70).firstN(1))

   def testRenameCollection(self):
      self._nautilus.upRemote()
      self._nautilus.rename(Pattern("1266310197088.png").similar(0.90).firstN(1), "renamed_collection", Pattern("1266310220931.png").similar(0.90).firstN(1))

nautilus = Nautilus()
test = NautilusWebdavTest(nautilus)
test.run()
