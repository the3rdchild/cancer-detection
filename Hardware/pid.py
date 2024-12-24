import serial
import time

ser = serial.Serial('COM4', 1900)

moveRotationCW  = bytearray([0xAA, 0x01, 0x0E])
moveRotationCCW = bytearray([0xAA, 0x02, 0x7E])
moveUp  = bytearray([0xAA, 0x12, 0x7E])
moveDown    = bytearray([0xAA, 0x04, 0x5E])

moveApalah   = bytearray([0xAA, 0x08, 0x1E])

//something code, no idea
