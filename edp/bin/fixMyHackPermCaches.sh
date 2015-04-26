echo "<b>Trying to fix kexts permissions and rebuild caches...</b>"

echo "<br>Copying myHack kext..."
rm -rf /System/Library/Extensions/myHack.kext
cp -rf /Extra/EDP/myHack.kext /System/Library/Extensions

echo "<br>Integrating kexts inide myHack kext..."
cp -a /Extra/Extensions/. /System/Library/Extensions/myHack.kext/Contents/PlugIns/
cp -a /Extra/Extensions/*.kext/Contents/PlugIns/ /System/Library/Extensions/myHack.kext/Contents/PlugIns/
rm -rf /System/Library/Extensions/myHack.kext/Contents/PlugIns/*.kext/Contents/PlugIns
cp -a /Extra/Extensions.EDPFix/. /System/Library/Extensions/myHack.kext/Contents/PlugIns/

echo "<br>Fixing permissions..."
chmod -R 755 /System/Library/Extensions
chown -R root:wheel /System/Library/Extensions

echo "<br>Rebuilding caches..."
rm -rf /System/Library/Caches/com.apple.kext.caches/Startup/*
touch /System/Library/Extensions
kextcache -system-prelinked-kernel
kextcache -u /

echo "<br><b>Fixing permissions and rebuilding caches are finished.</b>"
