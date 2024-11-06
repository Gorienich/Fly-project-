<?php
function fix_path($path) {
    return str_replace("\\", "/", $path);
}

function test_only_include($parent_index) {
    if (fix_path($_SERVER['SCRIPT_FILENAME']) == fix_path(__FILE__)) {
        if ($parent_index) {
            header("Location: ../index.php");
        } else {
            header("Location: index.php");
        }
        exit();
    }
}

function check_pattern($str, $pattern) {
    return preg_match("/" . $pattern . "/", $str);
}

function check_range($num, $min, $max) {
    if (!ctype_digit($num)) {
        return false;
    }
    $n = (int) $num;
    return $n <= $max && $n >= $min;
}

test_only_include(true);

class User {
    private $ID;
    private $email;
    private $firstname;
    private $lastname;
    private $age;
    private $enabled;
    private $admin;
    private $super_admin;

    public function __construct($ID, $email, $firstname, $lastname, $age, $enabled, $admin, $super_admin) {
        $this->ID = $ID;
        $this->email = $email;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->age = $age;
        $this->enabled = $enabled === 1;
        $this->admin = $admin === 1;
        $this->super_admin = $super_admin;
    }

    public function ID() {
        return $this->ID;
    }

    public function email() {
        return $this->email;
    }

    public function firstname() {
        return $this->firstname;
    }

    public function lastname() {
        return $this->lastname;
    }

    public function age() {
        return $this->age;
    }

    public function strictly_enabled() {
        return $this->enabled;
    }

    public function enabled() {
        return $this->enabled || $this->super_admin;
    }

    public function strictly_admin() {
        return $this->admin;
    }

    public function admin() {
        return $this->admin || $this->super_admin;
    }

    public function super_admin() {
        return $this->super_admin;
    }
}

function create_user($res) {
    return new User($res['id'], $res['email'], $res['first_name'], $res['last_name'], (int) $res['age'], (int) $res['enabled'], (int) $res['admin'], (int) $res['super_admin']);
}

class Plane {
    private $ID;
    private $type;
    private $manufacturer;
    public function __construct($ID, $type, $manufacturer) {
        $this->ID = $ID;
        $this->type = $type;
        $this->manufacturer = empty($manufacturer) ? null : $manufacturer;
    }

    public function ID() {
        return $this->ID;
    }

    public function type() {
        return $this->type;
    }

    public function manufacturer() {
        return $this->manufacturer;
    }
}

function create_plane($res) {
    return new Plane($res['id'], $res['type'], $res['manufacturer']);
}
?>