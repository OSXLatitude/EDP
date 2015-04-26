echo "<b>Trying to fix system kexts permissions and rebuild caches...</b>"

echo "<br>Fixing permissions..."
chmod -R 755 /System/Library/Extensions
chown -R root:wheel /System/Library/Extensions

echo "<br>Rebuilding caches..."
rm -rf /System/Library/Caches/com.apple.kext.caches/Startup/*
touch /System/Library/Extensions
kextcache -system-prelinked-kernel

echo "<br><b>Fixing permissions and rebuilding caches are finished.</b>"
