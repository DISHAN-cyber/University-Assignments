package game; 
  
abstract class Gun { 
  
    protected String name; 
    protected int bullets; 
    protected int magazineSize; 
  
    public Gun(String name, int bullets, int magazineSize) { 
        this.name = name; 
        this.bullets = Math.min(bullets, magazineSize); 
        this.magazineSize = magazineSize; 
    } 
  
    public abstract void shoot(); 
  
    public void reload(int ammo) { 
        bullets = Math.min(bullets + ammo, magazineSize); 
        System.out.println(name + " reloaded. Bullets now: " + bullets); 
    } 
  
    public String getName() { 
        return name; 
    } 
  
    public int getBullets() { 
        return bullets; 
    } 
} 
  
public class SimpleCombatSimulator { 
  
    public static void main(String[] args) { 
        Soldier soldier = new Soldier("Kavi"); 
  
        AK47 ak47 = new AK47(30); 
        Sniper sniper = new Sniper(6); 
        Pistol pistol = new Pistol(10); 
  
        soldier.pickGun(ak47); 
        soldier.pickGun(pistol); 
        soldier.pickGun(sniper); 
  
        soldier.shoot(); // AK47 
        soldier.switchGun(1); 
        soldier.shoot(); // Pistol 
        soldier.switchGun(2); 
        soldier.shoot(); // Sniper 
  
        soldier.reloadCurrentGun(0); 
        soldier.shoot(); 
  
        soldier.dropGun(1); // Drop Pistol 
        soldier.pickGun(new Pistol(10)); 
        soldier.shoot(); 
  
        soldier.switchGun(2); 
        soldier.shoot(); 
    } 
} 
  
class AK47 extends Gun { 
    public AK47(int bullets) { 
        super("AK47", bullets, 30); 
    } 
  
    @Override 
    public void shoot() { 
        if (bullets > 0) { 
            bullets--; 
            System.out.println(name + " fired. Bullets left: " + bullets); 
        } else { 
            System.out.println(name + " reload needed."); 
        } 
    } 
} 
  
class Pistol extends Gun { 
    public Pistol(int bullets) { 
        super("Pistol", bullets, 6); 
    } 
  
    @Override 
    public void shoot() { 
        if (bullets > 0) { 
            bullets--; 
            System.out.println(name + " fired. Bullets left: " + bullets); 
        } else { 
            System.out.println(name + " reload needed."); 
        } 
    } 
} 
  
class Sniper extends Gun { 
    public Sniper(int bullets) { 
        super("Sniper", bullets, 6); 
    } 
  
    @Override 
    public void shoot() { 
        if (bullets > 0) { 
            bullets--; 
            System.out.println(name + " fired. Bullets left: " + bullets); 
        } else { 
            System.out.println(name + " reload needed."); 
        } 
    } 
} 
  
class Soldier { 
    private String name; 
    private Gun[] guns; 
    private int currentGunIndex; 
    private int gunCount; 
  
    public Soldier(String name) { 
        this.name = name; 
        this.guns = new Gun[3]; 
        this.currentGunIndex = -1; 
        this.gunCount = 0; 
    } 
  
    public void pickGun(Gun gun) { 
        if (gunCount < 3) { 
            guns[gunCount] = gun; 
            gunCount++; 
            System.out.println(name + " picked up a " + gun.getName()); 
            if (currentGunIndex == -1) { 
                currentGunIndex = 0; 
            } 
        } else { 
            System.out.println(name + " already has 3 guns! Drop one first."); 
        } 
    } 
  
    public void dropGun(int index) { 
        if (index >= 0 && index < gunCount) { 
            System.out.println(name + " dropped the " + guns[index].getName()); 
            for (int i = index; i < gunCount - 1; i++) { 
                guns[i] = guns[i + 1]; 
            } 
            guns[gunCount - 1] = null; 
            gunCount--; 
            if (gunCount == 0) { 
                currentGunIndex = -1; 
            } else if (currentGunIndex >= gunCount) { 
                currentGunIndex = gunCount - 1; 
            } 
        } else { 
            System.out.println("Invalid gun index. Can't drop."); 
        } 
    } 
  
    public void switchGun(int index) { 
        if (index >= 0 && index < gunCount) { 
            currentGunIndex = index; 
            System.out.println(name + " switched to " + guns[index].getName()); 
        } else { 
            System.out.println("Invalid gun selection."); 
        } 
    } 
  
    public void shoot() { 
        if (currentGunIndex == -1) { 
            System.out.println(name + " has no gun to shoot!"); 
        } else { 
            guns[currentGunIndex].shoot(); 
        } 
    } 
  
    public void reloadCurrentGun(int ammo) { 
        if (currentGunIndex == -1) { 
            System.out.println(name + " has no gun to reload!"); 
        } else { 
            guns[currentGunIndex].reload(ammo); 
        } 
    } 
}