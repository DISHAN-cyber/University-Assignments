package calculator;

import com.formdev.flatlaf.FlatDarkLaf; 
import java.awt.BorderLayout;
import java.awt.Color;
import java.awt.Font;
import java.awt.GridLayout;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.awt.Dimension;
import java.awt.FlowLayout;
import javax.swing.BorderFactory;
import javax.swing.JButton;
import javax.swing.JFrame;
import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.JTextField;

class calculator implements ActionListener {

    static JButton b1, b2, b3, b4, b5, b6, b7, b8, b9, b10, b11, b12, b13, b14, b15, b16, b17, b18, b19, b20, b21, b22, b23, b24;
    static JTextField textField;

    String fv, op, av;
    Double fdv, adv, total;

    calculator() {
        JFrame frame = new JFrame("My Calculator");
        frame.setBounds(200, 200, 350, 500);
        frame.setLocationRelativeTo(null);
        frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);

        Font f1 = new Font("Poppins", Font.PLAIN, 15);
        Font f2 = new Font("Sans Serif", Font.BOLD, 14);
        Font f3 = new Font("Poppins", Font.PLAIN, 23);
        Font f4 = new Font("Sans Serif", Font.PLAIN, 16);

        JLabel headerLabel = new JLabel("Standard Calculator");
        headerLabel.setFont(f4);

        textField = new JTextField(25);
        textField.setFont(f3);
        textField.setText("0");
        textField.setHorizontalAlignment(JTextField.RIGHT);

        JPanel panel = new JPanel(new FlowLayout(FlowLayout.LEFT));
        panel.add(headerLabel);

        JPanel panel1 = new JPanel(new BorderLayout());
        panel1.setBorder(BorderFactory.createEmptyBorder(10, 10, 10, 10));
        panel1.add(textField, BorderLayout.CENTER);

        b1 = new JButton("CE");
        b1.setFont(f1);
        b1.setPreferredSize(new Dimension(60, 55));

        b2 = new JButton("C");
        b2.setFont(f1);
        b2.setPreferredSize(new Dimension(60, 55));

        b3 = new JButton("⌫");
        b3.setFont(f1);
        b3.setPreferredSize(new Dimension(60, 55));

        b4 = new JButton("%");
        b4.setFont(f1);
        b4.setPreferredSize(new Dimension(60, 55));

        b5 = new JButton("1/x");
        b5.setFont(f1);
        b5.setPreferredSize(new Dimension(60, 55));

        b6 = new JButton("x²");
        b6.setFont(f1);
        b6.setPreferredSize(new Dimension(60, 55));

        b7 = new JButton("√x");
        b7.setFont(f1);
        b7.setPreferredSize(new Dimension(60, 55));

        b8 = new JButton("/");
        b8.setFont(f1);
        b8.setPreferredSize(new Dimension(60, 55));

        b9 = new JButton("7");
        b9.setFont(f1);
        b9.setPreferredSize(new Dimension(60, 55));

        b10 = new JButton("8");
        b10.setFont(f1);
        b10.setPreferredSize(new Dimension(60, 55));

        b11 = new JButton("9");
        b11.setFont(f1);
        b11.setPreferredSize(new Dimension(60, 55));

        b12 = new JButton("x");
        b12.setFont(f1);
        b12.setPreferredSize(new Dimension(60, 55));

        b13 = new JButton("4");
        b13.setFont(f1);
        b13.setPreferredSize(new Dimension(60, 55));

        b14 = new JButton("5");
        b14.setFont(f1);
        b14.setPreferredSize(new Dimension(60, 50));

        b15 = new JButton("6");
        b15.setFont(f1);
        b15.setPreferredSize(new Dimension(60, 55));

        b16 = new JButton("-");
        b16.setFont(f1);
        b16.setPreferredSize(new Dimension(60, 55));

        b17 = new JButton("1");
        b17.setFont(f1);
        b17.setPreferredSize(new Dimension(60, 55));

        b18 = new JButton("2");
        b18.setFont(f1);
        b18.setPreferredSize(new Dimension(60, 55));

        b19 = new JButton("3");
        b19.setFont(f1);
        b19.setPreferredSize(new Dimension(60, 55));

        b20 = new JButton("+");
        b20.setFont(f1);
        b20.setPreferredSize(new Dimension(60, 55));

        b21 = new JButton("±");
        b21.setFont(f1);
        b21.setPreferredSize(new Dimension(60, 55));

        b22 = new JButton("0");
        b22.setFont(f1);
        b22.setPreferredSize(new Dimension(60, 55));

        b23 = new JButton(".");
        b23.setFont(f2);
        b23.setPreferredSize(new Dimension(60, 55));

        b24 = new JButton("=");
        b24.setFont(f1);
        b24.setPreferredSize(new Dimension(60, 55));
        b24.setBackground(Color.decode("#52a1cc"));

        JPanel buttonPanel = new JPanel();
        buttonPanel.setLayout(new GridLayout(6, 4, 5, 5));
        buttonPanel.setBorder(BorderFactory.createEmptyBorder(2, 10, 10, 10));

        buttonPanel.add(b1);
        buttonPanel.add(b2);
        buttonPanel.add(b3);
        buttonPanel.add(b4);
        buttonPanel.add(b5);
        buttonPanel.add(b6);
        buttonPanel.add(b7);
        buttonPanel.add(b8);
        buttonPanel.add(b9);
        buttonPanel.add(b10);
        buttonPanel.add(b11);
        buttonPanel.add(b12);
        buttonPanel.add(b13);
        buttonPanel.add(b14);
        buttonPanel.add(b15);
        buttonPanel.add(b16);
        buttonPanel.add(b17);
        buttonPanel.add(b18);
        buttonPanel.add(b19);
        buttonPanel.add(b20);
        buttonPanel.add(b21);
        buttonPanel.add(b22);
        buttonPanel.add(b23);
        buttonPanel.add(b24);

        b1.addActionListener(this);
        b2.addActionListener(this);
        b3.addActionListener(this);
        b4.addActionListener(this);
        b5.addActionListener(this);
        b6.addActionListener(this);
        b7.addActionListener(this);
        b8.addActionListener(this);
        b9.addActionListener(this);
        b10.addActionListener(this);
        b11.addActionListener(this);
        b12.addActionListener(this);
        b13.addActionListener(this);
        b14.addActionListener(this);
        b15.addActionListener(this);
        b16.addActionListener(this);
        b17.addActionListener(this);
        b18.addActionListener(this);
        b19.addActionListener(this);
        b20.addActionListener(this);
        b21.addActionListener(this);
        b22.addActionListener(this);
        b23.addActionListener(this);
        b24.addActionListener(this);

        frame.add(panel, BorderLayout.NORTH);
        frame.add(panel1, BorderLayout.CENTER);
        frame.add(buttonPanel, BorderLayout.SOUTH);

        frame.setVisible(true);
    }

    public static void main(String[] args) {
        try {
            FlatDarkLaf.setup(); // Set the FlatDarkLaf look and feel
        } catch (Exception e) {
            e.printStackTrace();
        }
        new calculator();
    }

    public void actionPerformed(ActionEvent e) {
        Object o = e.getSource();

        if (o.equals(b1)) {
            textField.setText(" ");
        } else if (o.equals(b2)) {
            textField.setText(" ");
        } else if (o.equals(b3)) {
            fv = textField.getText();
            if (!fv.isEmpty() && !fv.equals("0")) {
                fv = fv.substring(0, fv.length() - 1);
                if (fv.isEmpty()) {
                    textField.setText("0");
                } else {
                    textField.setText(fv);
                }
            }
        } else if (o.equals(b4)) {
            fv = textField.getText();
            op = b4.getText();
            textField.setText("");
        } else if (o.equals(b5)) {
            fv = textField.getText();
            op = b5.getText();
            textField.setText("");
        } else if (o.equals(b6)) {
            try {
                fv = textField.getText().trim();
                if (fv.isEmpty()) {
                    textField.setText("0");
                }
                double value = Double.parseDouble(fv);
                if (value < 0) {
                    textField.setText("Invalid Input");
                } else {
                    double result = Math.pow(value, 2);
                    textField.setText(formatResult(result)); // Use formatResult method
                }
            } catch (NumberFormatException exception) {
            }
        } else if (o.equals(b7)) {
            try {
                fv = textField.getText().trim();
                if (fv.isEmpty()) {
                    textField.setText("0");
                }
                double value = Double.parseDouble(fv);
                if (value < 0) {
                    textField.setText("Invalid Input");
                } else {
                    double result = Math.sqrt(value);
                    textField.setText(formatResult(result)); // Use formatResult method
                }
            } catch (NumberFormatException exception) {
                textField.setText("Error");
            }
        } else if (o.equals(b8)) {
            fv = textField.getText();
            op = b8.getText();
            textField.setText("");
        } else if (o.equals(b9)) {
            textField.setText(textField.getText() + b9.getText());
        } else if (o.equals(b10)) {
            textField.setText(textField.getText() + b10.getText());
        } else if (o.equals(b11)) {
            textField.setText(textField.getText() + b11.getText());
        } else if (o.equals(b12)) {
            fv = textField.getText();
            op = b12.getText();
            textField.setText("");
        } else if (o.equals(b13)) {
            textField.setText(textField.getText() + b13.getText());
        } else if (o.equals(b14)) {
            textField.setText(textField.getText() + b14.getText());
        } else if (o.equals(b15)) {
            textField.setText(textField.getText() + b15.getText());
        } else if (o.equals(b16)) {
            fv = textField.getText();
            op = b16.getText();
            textField.setText("");
        } else if (o.equals(b17)) {
            textField.setText(textField.getText() + b17.getText());
        } else if (o.equals(b18)) {
            textField.setText(textField.getText() + b18.getText());
        } else if (o.equals(b19)) {
            textField.setText(textField.getText() + b19.getText());
        } else if (o.equals(b20)) {
            fv = textField.getText();
            op = b20.getText();
            textField.setText("");
        } else if (o.equals(b21)) {
            try {
                fv = textField.getText().trim();
                double value = Double.parseDouble(fv);
                value = -value;
                textField.setText(formatResult(value)); // Use formatResult method
            } catch (NumberFormatException exception) {
            }
        } else if (o.equals(b22)) {
            textField.setText(textField.getText() + b22.getText());
        } else if (o.equals(b23)) {
            textField.setText(textField.getText() + b23.getText());
        } else if (o.equals(b24)) {
            av = textField.getText();
            textField.setText("");
            fdv = Double.parseDouble(fv);
            adv = Double.parseDouble(av);

            if (op.equals("+")) {
                total = fdv + adv;
                textField.setText(formatResult(total)); // Use formatResult method
            } else if (op.equals("-")) {
                total = fdv - adv;
                textField.setText(formatResult(total)); // Use formatResult method
            } else if (op.equals("x")) {
                total = fdv * adv;
                textField.setText(formatResult(total)); // Use formatResult method
            } else if (op.equals("/")) {
                if (adv == 0) {
                    textField.setText("cannot divided by 0");
                } else {
                    total = fdv / adv;
                    textField.setText(formatResult(total)); // Use formatResult method
                }
            } else if (op.equals("1/x")) {
                if (fdv == 0) {
                    textField.setText("cannot divided by 0");
                } else {
                    total = 1 / fdv;
                    textField.setText(formatResult(total)); // Use formatResult method
                }
            } else if (op.equals("%")) {
                if (adv != 0 || fdv != 0) {
                    total = (fdv * adv) / 100;
                    textField.setText(formatResult(total)); // Use formatResult method
                } else {
                    textField.setText("0");
                }
            }
        }
    }

    // Helper method to format the result
    private String formatResult(double result) {
        if (result == (long) result) {
            return String.valueOf((long) result); // Return as integer if whole number
        } else {
            return String.valueOf(result); // Return as string for decimal numbers
        }
    }
}
